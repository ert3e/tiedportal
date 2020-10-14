<?php

namespace App\Http\Controllers;

use App\AppTraits\HasAddresses;
use App\AppTraits\HasContacts;
use App\AppTraits\HasEditableAttributes;
use App\AppTraits\UploadsMedia;
use App\Models\ContactType;
use App\Models\ProjectType;
use App\Models\Supplier;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Breadcrumbs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Auth;
use \DB;
use JeroenDesloovere\VCard\VCard;

class SupplierController extends Controller
{
    use UploadsMedia;
    use HasAddresses;
    use HasContacts;
    use HasEditableAttributes;

    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('suppliers.title'), route('suppliers.index'));
    }

    public function index(Request $request) {

        $project_types = ProjectType::where('parent_id', 0)->orderBy('name')->lists('name', 'id');

        $term = '';
        $type = $request->input('type', false);
        $status = $request->input('status', false);
        if( $request->has('search') ) {

            $term = $request->get('search');
            $suppliers = Supplier::where('name', 'LIKE', '%' . $term . '%')
                ->orWhereHas('contacts', function($q) use($term) {
                    // This has to be nested or the inner join become an "OR" and returns all results
                    $q->where(function($q) use($term) {
                        $q->where('email', 'LIKE', $term . '%')->orWhere(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%');
                    });
                })
                ->orWhereHas('projectTypes', function($q) use($term) {
                    // This has to be nested or the inner join become an "OR" and returns all results
                    $q->where(function($q) use($term) {
                        $q->where('name', 'LIKE', '%' . $term . '%')->orWhere('description', 'LIKE', '%' . $term . '%');
                    });
                })
                ->orderBy('name', 'ASC');

        } else {
            $suppliers = Supplier::orderBy('name', 'ASC');
        }

        if( $status == 'verified' ) {
            $suppliers->verified();
        } else if( $status == 'unverified' ) {
            $suppliers->unverified();
        }

        if( $type ) {
            $project_type = ProjectType::find($type);
            if( $project_type ) {
                $suppliers->whereHas('projectTypes', function ($q) use ($project_type) {

                    if( $project_type->children()->count() ) {
                        $q->whereIn('id', $project_type->children()->lists('id'));
                    } else {
                        $q->where('id', $project_type->id);
                    }
                });
            }
        }

        $suppliers = $suppliers->paginate(25)->appends($request->all());

        $type_options = ['' => 'Show all'] + ProjectType::orderBy('name')->lists('name', 'id')->toArray();
        $statuses = ['' => 'Show all', 'verified' => 'Only verified', 'unverified' => 'Only unverified'];

        return view('suppliers.index', compact('suppliers', 'project_types', 'term', 'type_options', 'statuses', 'type', 'status'));
    }

    public function store(Request $request) {

        $rules = [
            'name'          => 'required',
            'description'   => 'required'
        ];

        $this->validate($request, $rules);

        $supplier = Supplier::create($request->only(['name', 'description']));

        return redirect()->route('suppliers.details', [$supplier->id]);
    }

    public function details($supplier) {
        Breadcrumbs::push($supplier->name, route('suppliers.details', $supplier->id));
        $project_types = ProjectType::where('parent_id', 0)->orderBy('name')->get();
        $contact_types = ContactType::orderBy('name')->lists('name', 'id');
        return view('suppliers.details', compact('supplier', 'project_types', 'contact_types'));
    }

    public function verify($supplier) {

        DB::transaction(function() use($supplier) {

            // We unset the event dispatcher to stop the updated event firing
            // and adding unnecessary events to the timeline.
            Supplier::unsetEventDispatcher();

            $supplier->verified = true;
            $supplier->verifiedBy()->associate(Auth::user());
            $supplier->verified_date = Carbon::now();
            $supplier->save();

            $event = Event::create([
                'event_class'   => 'verified',
                'metadata'      => [],
                'date'          => Carbon::now()
            ]);
            $event->eventable()->associate($supplier);
            Auth::user()->events()->save($event);
        });

        return redirect()->back()->with('success', 'Supplier verified!');
    }

    public function delete($supplier) {
        $supplier->delete();
        return redirect()->route('suppliers.index');
    }

    public function autocomplete($term) {

        $suppliers = Supplier::where('name', 'LIKE', '%' . $term . '%')
            ->orWhereHas('contacts', function($q) use($term) {
                // This has to be nested or the inner join become an "OR" and returns all results
                $q->where(function($q) use($term) {
                    $q->where('email', 'LIKE', $term . '%')->orWhere(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%');
                });
            })
            ->select(['id', 'name', 'description'])
            ->orderBy('name', 'ASC')
            ->take(15)
            ->get();

        return response()->json($suppliers);
    }


        public function downloadContacts($supplier)
        {

            // $contactTypes = DB::raw('SELECT * FROM contact_types')->get()->toArray();
            $contactTypesTemp = DB::table('contact_types')->get();
            $contactTypes = array();
            foreach($contactTypesTemp as $type)
                $contactTypes[$type->id] = $type;

            // dd('dada');
            // define vcard

            $vCardArray = array();
            foreach ($supplier->contacts as $c){
                // dd($c);
                $vcard = new VCard();
                $firstname = $c->first_name;
                $lastname = $c->last_name;
                $additional = '';
                $prefix = '';
                $suffix = '';
                $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);
                $vcard->addCompany($supplier->name);

                if((int)$c->contact_type_id > 0)
                    $vcard->addJobtitle($contactTypes[$c->contact_type_id]->name);

                if(trim($c->email))
                    $vcard->addEmail($c->email);

                if(trim($c->mobile))
                    $vcard->addPhoneNumber($c->mobile, 'PREF;MOBILE');

                if(trim($c->mobile))
                    $vcard->addPhoneNumber($c->telephone, 'WORK');

                if($c->media_id > 0  && is_file($c->imageUrl())){
                    $path = $c->imageUrl();
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $vcard->addPhoto($base64);
                }

                $vCardArray[] = $vcard->getOutput();
            }
            $vCard = implode("",$vCardArray);
            $headers = $vcard->getHeaders(true);
            $headers['Content-Disposition'] = "attachment; filename=". str_slug($supplier->name, '_') .".vcf";
            $headers['Content-Length'] = strlen($vCard);
            // dd($headers);

            return \Response::make(
                $vCard,
                200,
                $headers
            );
        }
}
