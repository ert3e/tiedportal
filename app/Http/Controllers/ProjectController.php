<?php

namespace App\Http\Controllers;

use App\AppTraits\HasAssignees;
use App\AppTraits\HasAttachments;
use App\AppTraits\HasComponents;
use App\AppTraits\HasEditableAttributes;
use App\AppTraits\HasNotes;
use App\AppTraits\HasSuppliers;
use App\AppTraits\HasTasks;
use App\AppTraits\UploadsMedia;
use App\Events\TimelineEventLoggedEvent;
use App\Models\Bill;
use App\Models\ComponentType;
use App\Models\ConversionReason;
use App\Models\Cost;
use App\Models\Customer;
use App\Models\LeadSource;
use App\Models\Supplier;
use App\Models\TaskType;
use App\Models\Task;
use \Permissions;
use \Config;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\ProspectStatus;
use App\Models\QuoteRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Breadcrumbs;
use App\Models\Project;
use \DB;
use App\Models\Event;
use \Auth;

class ProjectController extends Controller
{
    use HasComponents;
    use HasNotes;
    use HasAttachments;
    use UploadsMedia;
    use HasAssignees;
    use HasTasks;
    use HasEditableAttributes;
    use HasSuppliers;

    public function index(Request $request, $type = 'project') {

        $title = trans('projects.'.$type);
        Breadcrumbs::push($title, route('projects.index'));

        $type = str_singular($type);

        $term = '';
        $status = $request->input('status', session($type.'.status', ''));
        $owner = $request->input('owner', session($type.'.owner', 'assigned'));

        session([$type.'.status' => $status, $type.'.owner' => $owner]);

        if( $request->has('search') ) {

            $term = $request->get('search');
            $projects = Project::with('customer')
                ->where(function($q) use($term) {
                    $q->where('name', 'LIKE', '%'. $term . '%')->orWhere('id', $term)
                        ->orWhereHas('customer', function($q) use($term) {
                            // This has to be nested or the inner join become an "OR" and returns all results
                            $q->where('name', 'LIKE', '%' . $term . '%');
                        })
                        ->orWhereHas('types', function($q) use($term) {
                            // This has to be nested or the inner join become an "OR" and returns all results
                            $q->where(function($q) use($term) {
                                $q->where('name', 'LIKE', '%' . $term . '%')->orWhere('description', 'LIKE', '%' . $term . '%');
                            });
                        });

                });

        } else {
            $projects = Project::where('parent_id', 0);
        }

        if( $owner == 'internal' ) {
            $projects->where('scope', 'internal');
        } else if( $owner == 'external' ) {
            $projects->where('scope', 'external');
        } else if( $owner == 'mine' ) {
            $projects->mine();
        } else if( $owner == 'assigned' ) {
            $projects->assigned();
        }

        switch( $type ) {
            case 'prospect':
                $projects->prospects();
                $statuses = ['' => 'Show all'] + ProspectStatus::orderBy('name')->lists('name', 'id')->toArray();

                if( is_numeric($status) )
                    $projects->where('prospect_status_id', $status);

                break;
            case 'active':
                $projects->active();
                $statuses = ['' => 'Show all'] + ProjectStatus::orderBy('name')->lists('name', 'id')->toArray();

                if( is_numeric($status) )
                    $projects->where('project_status_id', $status);

                break;
            case 'lost':
                $projects->lost();
                $statuses = ['' => 'Show all'] + ProspectStatus::orderBy('name')->lists('name', 'id')->toArray();

                if( is_numeric($status) )
                    $projects->where('prospect_status_id', $status);

                break;
            case 'complete':
                $projects->complete();
                $statuses = ['' => 'Show all'] + ProjectStatus::orderBy('name')->lists('name', 'id')->toArray();

                if( is_numeric($status) )
                    $projects->where('project_status_id', $status);

                break;
            default:
                $projects->active();
        }

        $projects = $projects->orderBy('created_at', 'DESC')->paginate(25)->appends($request->all());

        $lead_sources = LeadSource::orderBy('name', 'ASC')->lists('name', 'id');
        $owner_options = ['mine' => 'Projects I created', 'assigned' => 'Projects I\'m asssigned to', 'all' => 'All projects', 'internal' => 'All internal projects', 'external' => 'All external projects'];

        return view('projects.index', compact('projects', 'term', 'type', 'lead_sources', 'project_types', 'project_type', 'statuses', 'status', 'owner_options', 'owner', 'task_types'));
    }

    public function delete($project) {
        $project->delete();
        return redirect()->route('projects.index', [$project->status]);
    }

    public function convert(Request $request, $project) {

        $rules = [
            'status'                => 'required|in:prospect,active,lost,complete',
            'conversion_reason_id'  => 'required|exists:conversion_reasons,id'
        ];

        $this->validate($request, $rules);

        DB::transaction(function() use($project, $request) {

            // We unset the event dispatcher to stop the updated event firing
            // and adding unnecessary events to the timeline.
            Project::unsetEventDispatcher();

            $project->status = $request->input('status');
            $project->conversion_reason_id = $request->input('conversion_reason_id', 0);
            $project->conversion_date = Carbon::now();
            $project->save();

            // Convert the customer object from a lead to a customer
            if( $project->customer->type != 'customer' ) {
                Customer::unsetEventDispatcher();
                $project->customer->type = 'customer';
                $project->customer->conversion_date = Carbon::now();
                $project->customer->save();

                $event = Event::create([
                    'event_class'   => 'conversion',
                    'metadata'      => [],
                    'date'          => Carbon::now()
                ]);
                $event->eventable()->associate($project->customer);
                Auth::user()->events()->save($event);
            }

            foreach( $project->children as $child ) {
                $child->status = $request->input('status');
                $child->conversion_reason_id = $request->input('conversion_reason_id', 0);
                $child->conversion_date = Carbon::now();
                $child->save();

                $event = Event::create([
                    'event_class'   => 'conversion',
                    'metadata'      => [],
                    'date'          => Carbon::now()
                ]);

                $event->eventable()->associate($child);
            }

            $event = Event::create([
                'event_class'   => 'conversion',
                'metadata'      => [],
                'date'          => Carbon::now()
            ]);

            $event->eventable()->associate($project);
            Auth::user()->events()->save($event);
        });

        return redirect()->route('projects.details', $project->id);
    }

    public function store(Request $request) {

        $rules = [
            'status'        => 'required|in:prospect,active,lost,complete',
            'customer_id'   => 'required|exists:customers,id',
            'name'          => 'required',
            'parent_id'     => 'exists:projects,id',
            'lead_source_id'=> 'exists:lead_sources,id'
        ];

        $this->validate($request, $rules);

        $input = $request->only('customer_id', 'name', 'description', 'scope');
        $input['status'] = $request->input('status', 'prospect');
        $input['parent_id'] = $request->input('parent_id', 0);
        $input['lead_source_id'] = $request->input('lead_source_id', 0);
        $input['user_id'] = \Auth::user()->id;
        $project = Project::create($input);

        return redirect()->route('projects.details', $project->id);
    }

    public function details($project) {

        if( $project->status == 'prospect' ) {
            Breadcrumbs::push(trans('projects.prospects'), route('projects.index', 'prospects'));
            $permission_group = 'leads';
        } else if( $project->status == 'active' ) {
            Breadcrumbs::push(trans('projects.active'), route('projects.index', 'active'));
            $permission_group = 'projects';
        } else if( $project->status == 'complete' ) {
            Breadcrumbs::push(trans('projects.complete'), route('projects.index', 'complete'));
            $permission_group = 'projects';
        } else if( $project->status == 'lost' ) {
            Breadcrumbs::push(trans('projects.lost'), route('projects.index', 'lost'));
            $permission_group = 'leads';
        }

        $parent_project = $project->parent;
        while( is_object($parent_project) ) {
            Breadcrumbs::push(trans($parent_project->name), route('projects.details', $parent_project->id));
            $parent_project = $parent_project->parent;
        }

        Breadcrumbs::push(trans($project->name), route('projects.details', $project->id));

        $project_types = ProjectType::where('parent_id', 0)->orderBy('name')->get();
        $project_statuses = ProjectStatus::orderBy('name')->get();
        $prospect_statuses = ProspectStatus::orderBy('name')->get();
        $lead_sources = LeadSource::orderBy('name', 'ASC')->get();

        $component_types = ComponentType::orderBy('name', 'ASC')->get();
        $conversion_reasons = ConversionReason::won()->orderBy('name', 'ASC')->lists('name', 'id');
        $loss_reasons = ConversionReason::lost()->orderBy('name', 'ASC')->lists('name', 'id');
        $task_types = ['' => 'None'] + TaskType::orderBy('name')->lists('name', 'id')->toArray();
        $priorities = Task::$priorities;

        $notes = $project->notes()->orderBy('updated_at', 'DESC')->get();
        $costs = $project->costs;
        $total_costs = $project->costs()->sum('cost');
        $total_value = $project->costs()->sum('value');
        $quote_requests = $project->quoteRequests()->has('supplier')->get();
        $profit = $total_value > 0 ? ($total_value - $total_costs) : 0;
        $profit_percent = $total_costs > 0 ? ($profit / $total_costs) * 100 : 100;

        $bills = $project->bills;
        $bill_total = $project->bills()->sum('amount');

        $quotes = collect([]);
        if( Permissions::has('quotes', 'view') ) {
            $quotes = $project->quotes()->has('supplier')->get();
        }

        $incoming_address = sprintf('crm+p%d@%s', $project->id, Config::get('mail.domain'));

        return view('projects.details', compact('project', 'permission_group', 'project_types', 'component_types', 'conversion_reasons', 'loss_reasons', 'notes', 'project_statuses', 'prospect_statuses', 'lead_sources', 'quotes', 'incoming_address', 'task_types', 'priorities', 'costs', 'quote_requests', 'total_costs', 'total_value', 'profit', 'profit_percent', 'bills', 'bill_total'));
    }

    public function autocomplete(Request $request, $term = '') {

        $term = $request->input('query', $term);
        $project_list = Project::with('customer')
            ->where('name', 'LIKE', '%' . $term . '%')
            ->orWhereHas('customer', function($q) use($term) {
                $q->where('name', 'LIKE', '%' . $term . '%');
            })
            ->take(15)
            ->get();

        $projects = [];
        foreach( $project_list as $project ) {
            $projects[] = [
                'id'    => $project->id,
                'name'  => sprintf('%s (%s)', $project->name, $project->customer->name)
            ];
        }

        $projects = collect($projects)->sortBy('text')->values()->all();

        return response()->json($projects);
    }

    public function complete(Request $request, $project) {

        DB::transaction(function() use($project, $request) {

            // We unset the event dispatcher to stop the updated event firing
            // and adding unnecessary events to the timeline.
            Project::unsetEventDispatcher();

            $project->status = 'complete';
            $project->save();

            foreach( $project->children as $child ) {
                $child->status = 'complete';
                $child->save();

                $event = Event::create([
                    'event_class'   => 'completed',
                    'metadata'      => [],
                    'date'          => Carbon::now()
                ]);

                $event->eventable()->associate($child);
            }

            $event = Event::create([
                'event_class'   => 'completed',
                'metadata'      => [],
                'date'          => Carbon::now()
            ]);

            $event->eventable()->associate($project);
            Auth::user()->events()->save($event);

            \Event::fire(new TimelineEventLoggedEvent($event));
        });

        return redirect()->route('projects.details', $project->id);
    }

    public function addCost(Request $request, $project) {

        $rules = [
            'supplier_id'   => 'exists:suppliers,id',
            'value'         => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $description = $request->input('description', '');
        $value = $request->input('value', 0);
        $cost = $request->input('cost', 0);

        // Create a cost object
        $cost = new Cost([
            'value'             => $value,
            'cost'              => $cost,
            'description'       => $description
        ]);

        $cost->project()->associate($project);

        if( $request->has('supplier_id') ) {
            $supplier = Supplier::find($request->input('supplier_id'));
            $cost->supplier()->associate($supplier);
        }
        $cost->save();

        return redirect()->route('projects.details', [$project->id, '#finance'])->with('success', 'Cost added successfully!');
    }

    public function addBill(Request $request, $project) {

        $rules = [
            'supplier_id'   => 'required|exists:suppliers,id',
            'amount'        => 'required|numeric',
            'reference'     => 'required',
            'date'          => 'required|date_format:d/m/Y',
            'due_date'      => 'required|date_format:d/m/Y',
            'paid_date'     => 'date_format:d/m/Y',
            'file'          => 'required'
        ];

        $this->validate($request, $rules);

        DB::transaction(function() use($request, $project) {

            $reference = $request->input('reference', '');
            $amount = $request->input('amount', '');
            $date = $request->input('date', Carbon::now());
            $due_date = $request->input('due_date', Carbon::now());
            $paid_date = $request->input('paid_date', '');

            // Create a bill object
            $bill = new Bill([
                'amount'            => $amount,
                'reference'         => $reference,
                'date'              => Carbon::createFromFormat('d/m/Y', $date),
                'due_date'          => Carbon::createFromFormat('d/m/Y', $due_date),
                'paid_date'         => empty($paid_date) ? null : Carbon::createFromFormat('d/m/Y', $paid_date)
            ]);

            $bill->project()->associate($project);

            if( $request->has('supplier_id') ) {
                $supplier = Supplier::find($request->input('supplier_id'));
                $bill->supplier()->associate($supplier);
            }

            $media = $this->attachMedia($request, 'file');
            $bill->media()->associate($media);

            $bill->save();
        });

        return redirect()->route('projects.details', [$project->id, '#finance'])->with('success', 'Bill added successfully!');
    }
}
