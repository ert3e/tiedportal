<?php namespace App\AppTraits;
use App\Models\Component;
use App\Models\ComponentFieldValue;
use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \DB;
use \Crypt;
use Mockery\CountValidator\Exception;

/**
 * Created by PhpStorm.
 * User: dan
 * Date: 16/02/2016
 * Time: 11:40
 */

trait HasComponents {

    public function createComponent($object, $component_type) {
        return view('components.create', compact('component_type', 'object'));
    }

    public function storeComponent(Request $request, $object, $component_type) {

        $rules = [
            'fields'    => 'required'
        ];

        $this->validate($request, $rules);

        $input = $request->input('fields');

        DB::transaction(function() use($component_type, $object, $input, $request) {

            $component = Component::create([
                'name'  => $component_type->name
            ]);
            $component->componentType()->associate($component_type);

            foreach( $component_type->fields as $component_field ) {

                if( $component_field->type != 'file' && !array_key_exists($component_field->id, $input) )
                    continue;

                $value = null;

                switch( $component_field->type ) {

                    case 'password':
                        $value = Crypt::encrypt($input[$component_field->id]);
                        break;

                    case 'longtext':
                    case 'text':
                        $value = $input[$component_field->id];
                        break;

                    case 'number':
                        $value = intval($input[$component_field->id]);
                        break;

                    case 'decimal':
                        $value = doubleval($input[$component_field->id]);
                        break;

                    case 'date':
                        $value = Carbon::parse($input[$component_field->id]);
                        break;

                    case 'time':
                        $value = $input[$component_field->id];
                        break;

                    case 'datetime':
                        $value = Carbon::parse($input[$component_field->id]['date'] . ' ' . $input[$component_field->id]['time']);
                        break;

                    case 'file':
                        $file = $request->file('fields.' . $component_field->id);

                        if( is_object($file) ) {
                            $media = Media::create([
                                'name' => $file->getClientOriginalName(),
                                'description' => '',
                                'mime_type' => $file->getMimeType()
                            ]);

                            $uploads_path = sprintf('%s/uploads', storage_path());

                            if (!is_dir($uploads_path))
                                mkdir($uploads_path);

                            if (!$file->move($uploads_path, $media->id)) {
                                throw new Exception('Failed to move uploaded file');
                            }

                            $value = $media->id;
                        }
                        break;
                }
                // TODO: Handle validation

                if( is_null($value) )
                    continue;

                $field_value = ComponentFieldValue::create([
                    'value'     => $value
                ]);
                $field_value->componentField()->associate($component_field);
                $component->values()->save($field_value);
            }

            $component->componentable()->associate($object);
            $component->save();
        });

        return redirect()->back()->with('success', sprintf('%s successfully added!', $component_type->name));
    }
}