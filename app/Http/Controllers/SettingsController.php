<?php

namespace App\Http\Controllers;

use App\Models\ComponentType;
use App\Models\ContactType;
use App\Models\ConversionReason;
use App\Models\ExpenseType;
use App\Models\InvoiceStatus;
use App\Models\InvoiceType;
use App\Models\LeadSource;
use App\Models\Media;
use App\Models\CustomerType;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\ProspectStatus;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\WorkflowItemStatus;
use Illuminate\Http\Request;
use \Permissions;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Breadcrumbs;

class SettingsController extends Controller
{
    // TODO: This could be refactored into a class map.

    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('settings.title'), route('settings.index'));
    }

    public function index() {
        $settings = [
            ['name' => trans('settings.types.contacttypes.title'), 'description' => trans('settings.types.contacttypes.description'), 'url' => route('settings.overview', 'contacttypes')],
            ['name' => trans('settings.types.customertypes.title'), 'description' => trans('settings.types.customertypes.description'), 'url' => route('settings.overview', 'customertypes')],
            ['name' => trans('settings.types.projecttypes.title'), 'description' => trans('settings.types.projecttypes.description'), 'url' => route('settings.overview', 'projecttypes')],
            ['name' => trans('settings.types.prospectstatuses.title'), 'description' => trans('settings.types.prospectstatuses.description'), 'url' => route('settings.overview', 'prospectstatuses')],
            ['name' => trans('settings.types.projectstatuses.title'), 'description' => trans('settings.types.projectstatuses.description'), 'url' => route('settings.overview', 'projectstatuses')],
            ['name' => trans('settings.types.conversionreasons.title'), 'description' => trans('settings.types.conversionreasons.description'), 'url' => route('settings.overview', 'conversionreasons')],
            ['name' => trans('settings.types.leadsources.title'), 'description' => trans('settings.types.leadsources.description'), 'url' => route('settings.overview', 'leadsources')],
            ['name' => trans('settings.types.workflowitemstatuses.title'), 'description' => trans('settings.types.workflowitemstatuses.description'), 'url' => route('settings.overview', 'workflowitemstatuses')],
            ['name' => trans('settings.types.invoicetypes.title'), 'description' => trans('settings.types.invoicetypes.description'), 'url' => route('settings.overview', 'invoicetypes')],
            ['name' => trans('settings.types.invoicestatuses.title'), 'description' => trans('settings.types.invoicestatuses.description'), 'url' => route('settings.overview', 'invoicestatuses')],
            ['name' => trans('settings.types.expensetypes.title'), 'description' => trans('settings.types.expensetypes.description'), 'url' => route('settings.overview', 'expensetypes')],
            ['name' => trans('settings.types.tasktypes.title'), 'description' => trans('settings.types.tasktypes.description'), 'url' => route('settings.overview', 'tasktypes')],
            ['name' => trans('settings.types.taskstatuses.title'), 'description' => trans('settings.types.taskstatuses.description'), 'url' => route('settings.overview', 'taskstatuses')],
        ];

        if( Permissions::has('permissions', 'view') ) {
            $settings[] = ['name' => trans('settings.types.roles.title'), 'description' => trans('settings.types.roles.description'), 'url' => route('roles.index')];
        }

        if( Permissions::has('users', 'view') ) {
            $settings[] = ['name' => trans('settings.types.users.title'), 'description' => trans('settings.types.users.description'), 'url' => route('users.index')];
        }

        if( Permissions::has('component-types', 'view') ) {
            $settings[] = ['name' => trans('settings.types.componenttypes.title'), 'description' => trans('settings.types.componenttypes.description'), 'url' => route('component-types.index')];
        }

        return view('settings.index', compact('settings'));
    }

    public function overview(Request $request, $type) {

        switch( $type ) {
            case 'contacttypes':
                $title = trans('settings.types.contacttypes.title');
                $fields = ContactType::$fields;
                $class = ContactType::class;
                $items = ContactType::orderBy('name')->get();
                break;

            case 'customertypes':
                $title = trans('settings.types.customertypes.title');
                $fields = CustomerType::$fields;
                $class = CustomerType::class;
                $items = CustomerType::orderBy('name')->get();
                break;

            case 'projecttypes':
                $title = trans('settings.types.projecttypes.title');
                $fields = ProjectType::$fields;
                $class = ProjectType::class;
                $items = ProjectType::orderBy('name')->get();
                break;

            case 'conversionreasons':
                $title = trans('settings.types.conversionreasons.title');
                $fields = ConversionReason::$fields;
                $class = ConversionReason::class;
                $items = ConversionReason::orderBy('name')->get();
                break;

            case 'leadsources':
                $title = trans('settings.types.leadsources.title');
                $fields = LeadSource::$fields;
                $class = LeadSource::class;
                $items = LeadSource::orderBy('name')->get();
                break;

            case 'componenttypes':
                $title = trans('settings.types.componenttypes.title');
                $fields = ComponentType::$fields;
                $class = ComponentType::class;
                $items = ComponentType::orderBy('name')->get();
                break;

            case 'workflowitemstatuses':
                $title = trans('settings.types.workflowitemstatuses.title');
                $fields = WorkflowItemStatus::$fields;
                $class = WorkflowItemStatus::class;
                $items = WorkflowItemStatus::orderBy('name')->get();
                break;

            case 'invoicetypes':
                $title = trans('settings.types.invoicetypes.title');
                $fields = InvoiceType::$fields;
                $class = InvoiceType::class;
                $items = InvoiceType::orderBy('name')->get();
                break;

            case 'invoicestatuses':
                $title = trans('settings.types.invoicestatuses.title');
                $fields = InvoiceStatus::$fields;
                $class = InvoiceStatus::class;
                $items = InvoiceStatus::orderBy('name')->get();
                break;

            case 'projectstatuses':
                $title = trans('settings.types.projectstatuses.title');
                $fields = ProjectStatus::$fields;
                $class = ProjectStatus::class;
                $items = ProjectStatus::orderBy('name')->get();
                break;

            case 'prospectstatuses':
                $title = trans('settings.types.prospectstatuses.title');
                $fields = ProspectStatus::$fields;
                $class = ProspectStatus::class;
                $items = ProspectStatus::orderBy('name')->get();
                break;

            case 'expensetypes':
                $title = trans('settings.types.expensetypes.title');
                $fields = ExpenseType::$fields;
                $class = ExpenseType::class;
                $items = ExpenseType::orderBy('name')->get();
                break;

            case 'tasktypes':
                $title = trans('settings.types.tasktypes.title');
                $fields = TaskType::$fields;
                $class = TaskType::class;
                $items = TaskType::orderBy('name')->get();
                break;

            case 'taskstatuses':
                $title = trans('settings.types.taskstatuses.title');
                $fields = TaskStatus::$fields;
                $class = TaskStatus::class;
                $items = TaskStatus::orderBy('name')->get();
                break;
        }

        // Load any necessary values
        foreach( $fields as &$field ) {
            if( $field['type'] == 'select' ) {
                $field['values'] = $class::{$field['values']}();
            }
        }

        Breadcrumbs::push($title, $request->url());

        return view('settings.overview', compact('title', 'fields', 'items', 'type'));
    }

    public function store(Request $request, $type) {

        switch( $type ) {
            case 'contacttypes':
                $fields = ContactType::$fields;
                ContactType::create($request->only(array_keys($fields)));
                break;

            case 'customertypes':
                $fields = CustomerType::$fields;
                CustomerType::create($request->only(array_keys($fields)));
                break;

            case 'projecttypes':
                $fields = ProjectType::$fields;
                ProjectType::create($request->only(array_keys($fields)));
                break;

            case 'conversionreasons':
                $fields = ConversionReason::$fields;
                ConversionReason::create($request->only(array_keys($fields)));
                break;

            case 'leadsources':
                $fields = LeadSource::$fields;
                LeadSource::create($request->only(array_keys($fields)));
                break;

            case 'componenttypes':
                $fields = ComponentType::$fields;
                ComponentType::create($request->only(array_keys($fields)));
                break;

            case 'workflowitemstatuses':
                $fields = WorkflowItemStatus::$fields;
                WorkflowItemStatus::create($request->only(array_keys($fields)));
                break;

            case 'invoicetypes':
                $fields = InvoiceType::$fields;
                InvoiceType::create($request->only(array_keys($fields)));
                break;

            case 'invoicestatuses':
                $fields = InvoiceStatus::$fields;
                InvoiceStatus::create($request->only(array_keys($fields)));
                break;

            case 'projectstatuses':
                $fields = ProjectStatus::$fields;
                ProjectStatus::create($request->only(array_keys($fields)));
                break;

            case 'prospectstatuses':
                $fields = ProspectStatus::$fields;
                ProspectStatus::create($request->only(array_keys($fields)));
                break;

            case 'expensetypes':
                $fields = ExpenseType::$fields;
                ExpenseType::create($request->only(array_keys($fields)));
                break;

            case 'tasktypes':
                $fields = TaskType::$fields;
                TaskType::create($request->only(array_keys($fields)));
                break;

            case 'taskstatuses':
                $fields = TaskStatus::$fields;
                TaskStatus::create($request->only(array_keys($fields)));
                break;
        }

        return redirect()->back()->with('success', 'Item saved!');
    }

    public function delete(Request $request, $type) {

        switch( $type ) {
            case 'contacttypes':
                $object = ContactType::find($request->input('id'));
                break;

            case 'customertypes':
                $object = CustomerType::find($request->input('id'));
                break;

            case 'projecttypes':
                $object = ProjectType::find($request->input('id'));
                break;

            case 'conversionreasons':
                $object = ConversionReason::find($request->input('id'));
                break;

            case 'leadsources':
                $object = LeadSource::find($request->input('id'));
                break;

            case 'componenttypes':
                $object = ComponentType::find($request->input('id'));
                break;

            case 'workflowitemstatuses':
                $object = WorkflowItemStatus::find($request->input('id'));
                break;

            case 'invoicetypes':
                $object = InvoiceType::find($request->input('id'));
                break;

            case 'invoicestatuses':
                $object = InvoiceStatus::find($request->input('id'));
                break;

            case 'projectstatuses':
                $object = ProjectStatus::find($request->input('id'));
                break;

            case 'prospectstatuses':
                $object = ProspectStatus::find($request->input('id'));
                break;

            case 'expensetypes':
                $object = ExpenseType::find($request->input('id'));
                break;

            case 'tasktypes':
                $object = TaskType::find($request->input('id'));
                break;

            case 'taskstatuses':
                $object = TaskStatus::find($request->input('id'));
                break;
        }

        // TODO: Re-assign objects to a different type?

        if( is_object($object) )
            $object->delete();

        return response()->json(['success' => true]);
    }

    public function edit(Request $request, $type, $id) {

        switch( $type ) {
            case 'contacttypes':
                $title = trans('settings.types.contacttypes.title');
                $fields = ContactType::$fields;
                $item = ContactType::find($id);
                break;

            case 'customertypes':
                $title = trans('settings.types.customertypes.title');
                $fields = CustomerType::$fields;
                $item = CustomerType::find($id);
                break;

            case 'projecttypes':
                $title = trans('settings.types.projecttypes.title');
                $fields = ProjectType::$fields;
                $item = ProjectType::find($id);
                break;

            case 'conversionreasons':
                $title = trans('settings.types.conversionreasons.title');
                $fields = ConversionReason::$fields;
                $item = ConversionReason::find($id);
                break;

            case 'leadsources':
                $title = trans('settings.types.leadsources.title');
                $fields = LeadSource::$fields;
                $item = LeadSource::find($id);
                break;

            case 'componenttypes':
                $title = trans('settings.types.componenttypes.title');
                $fields = ComponentType::$fields;
                $item = ComponentType::find($id);
                break;

            case 'workflowitemstatuses':
                $title = trans('settings.types.workflowitemstatuses.title');
                $fields = WorkflowItemStatus::$fields;
                $item = WorkflowItemStatus::find($id);
                break;

            case 'invoicetypes':
                $title = trans('settings.types.invoicetypes.title');
                $fields = InvoiceType::$fields;
                $item = InvoiceType::find($id);
                break;

            case 'invoicestatuses':
                $title = trans('settings.types.invoicestatuses.title');
                $fields = InvoiceStatus::$fields;
                $item = InvoiceStatus::find($id);
                break;

            case 'projectstatuses':
                $title = trans('settings.types.projectstatuses.title');
                $fields = ProjectStatus::$fields;
                $item = ProjectStatus::find($id);
                break;

            case 'prospectstatuses':
                $title = trans('settings.types.prospectstatuses.title');
                $fields = ProspectStatus::$fields;
                $item = ProspectStatus::find($id);
                break;

            case 'expensetypes':
                $title = trans('settings.types.expensetypes.title');
                $fields = ExpenseType::$fields;
                $item = ExpenseType::find($id);
                break;

            case 'tasktypes':
                $title = trans('settings.types.tasktypes.title');
                $fields = TaskType::$fields;
                $item = TaskType::find($id);
                break;

            case 'taskstatuses':
                $title = trans('settings.types.taskstatuses.title');
                $fields = TaskStatus::$fields;
                $item = TaskStatus::find($id);
                break;
        }

        return view('settings.edit', compact('item', 'fields', 'title', 'type', 'id'));
    }

    public function update(Request $request, $type, $id) {

        switch( $type ) {
            case 'contacttypes':
                $fields = ContactType::$fields;
                $item = ContactType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'customertypes':
                $fields = CustomerType::$fields;
                $item = CustomerType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'projecttypes':
                $fields = ProjectType::$fields;
                $item = ProjectType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'conversionreasons':
                $fields = ConversionReason::$fields;
                $item = ConversionReason::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'leadsources':
                $fields = LeadSource::$fields;
                $item = LeadSource::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'componenttypes':
                $fields = ComponentType::$fields;
                $item = ComponentType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'workflowitemstatuses':
                $fields = WorkflowItemStatus::$fields;
                $item = WorkflowItemStatus::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'invoicetypes':
                $fields = InvoiceType::$fields;
                $item = InvoiceType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'invoicestatuses':
                $fields = InvoiceStatus::$fields;
                $item = InvoiceStatus::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'projectstatuses':
                $fields = ProjectStatus::$fields;
                $item = ProjectStatus::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'prospectstatuses':
                $fields = ProspectStatus::$fields;
                $item = ProspectStatus::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'expensetypes':
                $fields = ExpenseType::$fields;
                $item = ExpenseType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'tasktypes':
                $fields = TaskType::$fields;
                $item = TaskType::find($id);
                $item->update($request->only(array_keys($fields)));
                break;

            case 'taskstatuses':
                $fields = TaskStatus::$fields;
                $item = TaskStatus::find($id);
                $item->update($request->only(array_keys($fields)));
                break;
        }

        return redirect()->route('settings.overview', $type);
    }
}
