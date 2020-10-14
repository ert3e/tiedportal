<?php namespace App\AppTraits;
use App\Jobs\SendTaskUpdatedEmail;
use App\Jobs\SendProjectUpdatedEmail;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Hash;
use \Auth;
use \FieldRenderer;

/**
 * Created by PhpStorm.
 * User: dan
 * Date: 01/02/2016
 * Time: 13:11
 */

trait HasEditableAttributes {

    public function update(Request $request) {

        $arguments = func_get_args();
        $object = array_pop($arguments);

        // This could be a name / value update as used by X-Editable
        if( $request->has('name') && $request->has('value') ) {

            $name = $request->input('name');

            $fillable = $object->getFillable();

            $rules = [
                'name'  => 'in:' . implode(',', $fillable)
            ];

            // Then we validate the actual value
            if( method_exists($object, 'rules') ) {
                $class_rules = $object->rules();

                if( array_key_exists($name, $class_rules) ) {
                    $rules['value'] = $class_rules[$name];
                }
            }

            $this->validate($request, $rules);

            $inputs = $request->only(['name', 'value']);
            $input_name = $inputs['name'];

            if( $name == 'password' && is_array($inputs['value']) ) {

                // This is a password field
                $rules = [
                    'value[password]'  => 'confirmed'
                ];

                $this->validate($request, $rules);

                $object->password = Hash::make(array_get($inputs, 'value.password'));
                $object->save();
                $value = '*******';

            } else if( is_array($inputs['value']) ) {

                // Array of values
                $object->$input_name()->sync($inputs['value']);
                $value = false;

            } else if( in_array($inputs['name'], $object->getDates()) ) {

                // Date field
                $object->$input_name = Carbon::createFromFormat('d/m/Y', $inputs['value']);
                $object->save();
                $value = $inputs['value'];

            } else {
                // Standard field
                $object->$input_name = trim($inputs['value']);
                $object->save();

                $value = $this->_renderValue($object, $inputs['name'], trim($inputs['value']));
            }
        } else {

            // Or a standard update using key/value inputs

            // First we validate that we have the name and the value
            $rules = $object->rules();

            $this->validate($request, $rules);

            $fillable = $object->getFillable();
            $object->update($request->only($fillable));
            $value = false;
        }

        return response()->json(['success' => true, 'value' => $value]);
    }

    private function _renderValue($object, $field, $value) {

        $class = get_class($object);

        if( property_exists($class, 'display_names') ) {

            if( property_exists($class, 'property_map') && array_key_exists($field, $class::$property_map) ) {

                $property_class = $class::$property_map[$field];

                if( is_array($property_class) ) {

                    $value = array_get($property_class, $value, $value);

                } else {
                    $value_object = $property_class::find($value);

                    if (is_object($value_object)) {
                        if (method_exists($value_object, 'displayName'))
                            $text_value = $value_object->displayName();
                        else if (property_exists($value_object, 'name'))
                            $text_value = $value_object->name;

                        $traits = class_uses($property_class);

                        if (in_array('App\AppTraits\HasColour', $traits)) {
                            $value = sprintf('<span class="label label-default" style="background-color: #%s">%s</span>', $value_object->colour, $text_value);
                        } else {
                            $value = $text_value;
                        }
                    }
                }
            }
        }

        return FieldRenderer::longtext($value);
    }
}
