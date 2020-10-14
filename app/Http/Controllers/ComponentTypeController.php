<?php

namespace App\Http\Controllers;

use App\AppTraits\HasEditableAttributes;
use App\Models\ComponentField;
use App\Models\ComponentType;
use Illuminate\Http\Request;
use \Breadcrumbs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \DB;

class ComponentTypeController extends Controller
{
    use HasEditableAttributes;

    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('settings.title'), route('settings.index'));
        Breadcrumbs::push(trans('settings.types.componenttypes.title'), route('component-types.index'));
    }

    public function index() {
        $component_types = ComponentType::orderBy('name', 'ASC')->get();
        return view('component-types.index', compact('component_types'));
    }

    public function store(Request $request) {

        $rules = [
            'name'          => 'required'
        ];

        $this->validate($request, $rules);

        $component_type = ComponentType::create($request->only(['name', 'colour', 'description']));

        return redirect()->route('component-types.details', [$component_type->id]);
    }

    public function details($component_type) {
        Breadcrumbs::push($component_type->name, route('component-types.details', $component_type->id));

        $field_types = [
            ''          => '-- Select a field type --',
            'password'  => 'Stores password encrpyted',
            'text'      => 'Short text input',
            'longtext'  => 'Long text input',
            'number'    => 'Number input',
            'decimal'   => 'Decimal number input',
            'date'      => 'Date selector',
            'time'      => 'Time selector',
            'datetime'  => 'Date and time selector',
            'file'      => 'File input'
        ];

        return view('component-types.details', compact('component_type', 'field_types'));
    }

    public function delete($component_type) {
        $component_type->delete();
        return redirect()->route('component-types.index');
    }

    /*
     * Fields
     */
    public function storeField(Request $request, $component_type) {

        $rules = [
            'name'      => 'required',
            'type'      => 'required|in:text,password,longtext,number,decimal,date,time,datetime,file'
        ];

        $this->validate($request, $rules);

        DB::transaction(function() use($request, $component_type) {
            $field = ComponentField::create($request->only('name', 'description', 'type'));
            $component_type->fields()->save($field);
        });

        return redirect()->route('component-types.details', $component_type->id);
    }

    public function deleteField($component_type, $field) {

        if( $field->componentType->id != $component_type->id )
            abort(400);

        $field->delete();

        return redirect()->back();
    }
}
