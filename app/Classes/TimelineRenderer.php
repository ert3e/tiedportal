<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 23/02/2016
 * Time: 13:07
 */

namespace App\Classes;

use App\Models\Media;
use Carbon\Carbon;
use \Auth;
use \InvalidArgumentException;
use \Permissions as SystemPermissions;
use \FieldRenderer as Renderer;

class TimelineRenderer
{
    public function user($event) {

        if( (Auth::check() && is_object($event->user) && $event->user->id == Auth::user()->id) || SystemPermissions::has('users', 'view') ) {

            if( !is_object($event->user) )
                return 'Unknown User';

            if( is_object($event->user->contact) && strlen($event->user->contact->first_name) )
                return sprintf('<a href="%s" class="text-default">%s %s</a>', route('users.profile', $event->user->id), $event->user->contact->first_name, $event->user->contact->last_name);

            return sprintf('<a href="%s" class="text-default">%s</a>', route('users.profile', $event->user->id), $event->user->username);
        }

        if( is_object($event->user->contact) && strlen($event->user->contact->first_name) )
            return sprintf('<span class="text-default">%s %s</span>', $event->user->contact->first_name, $event->user->contact->last_name);

        return sprintf('<span class="text-default">%s</span>', $event->user->username);
    }

    public function url($event) {

        return Renderer::url($event->eventable);
    }

    public function description($event) {

        $description = '';

        if( !is_object($event->eventable) ) {
            return 'Unknown event ' . $event->event_class;
        }

        switch( $event->event_class ) {

            case 'created':
            {
                $description = sprintf('created %s', $event->eventable->object_type);
                break;
            }

            case 'updated':
            {
                $description = $this->_describeUpdate($event);
                break;
            }

            case 'deleted':
            {
                $description = sprintf('deleted %s', $event->eventable->object_type);
                break;
            }

            case 'conversion':
            {
                $description = sprintf('converted %s', $event->eventable->object_type);
                break;
            }

            case 'verified':
            {
                $description = sprintf('verified %s', $event->eventable->object_type);
                break;
            }

            case 'completed':
            {
                $description = sprintf('completed %s', $event->eventable->object_type);
                break;
            }
        }

        return $description;
    }

    public function time($event) {

        if( !is_object($event->date) ) {
            return 'Unknown';
        }

        return $event->date->diffForHumans();
    }

    public function _describeUpdate($event) {

        $description = '';
        $class = $event->eventable_type;
        $instance = new $class();

        if( property_exists($class, 'display_names') && !is_null($event->metadata) ) {

            foreach ($event->metadata->fields as $field) {

                $description .= 'updated ';

                if( array_key_exists($field->field, $class::$display_names) ) {

                    $old_value = strip_tags($field->old);
                    $new_value = strip_tags($field->new);

                    if( property_exists($class, 'property_map') && array_key_exists($field->field, $class::$property_map) ) {

                        $property_class = $class::$property_map[$field->field];

                        if( is_array($property_class) ) {

                            $old_value = array_get($property_class, $old_value, $old_value);
                            $new_value = array_get($property_class, $new_value, $new_value);

                        } else {
                            $old_object = $property_class::find($field->old);
                            $new_object = $property_class::find($field->new);

                            if (is_object($old_object)) {
                                if (method_exists($old_object, 'displayName'))
                                    $old_value = $old_object->displayName();
                                else if (property_exists($old_object, 'name'))
                                    $old_value = $old_object->name;
                            }

                            if (is_object($new_object)) {
                                if (method_exists($new_object, 'displayName'))
                                    $new_value = $new_object->displayName();
                                else if (property_exists($old_object, 'name'))
                                    $new_value = $new_object->name;
                            }
                        }

                    } else {

                        if (in_array($field->field, $instance->getDates())) {
                            try {
                                $new_value = Carbon::createFromFormat('Y-m-d H:i:s', $field->new)->format('d/m/Y');
                            } catch (InvalidArgumentException $e) {
                                $new_value = '';
                            }

                            try {
                                $date = Carbon::createFromFormat('Y-m-d H:i:s', $field->old);
                                if ($date->format('Y') > 1980)
                                    $old_value = $date->format('d/m/Y');
                                else
                                    $old_value = '';
                            } catch (InvalidArgumentException $e) {
                                $old_value = '';
                            }
                        } else {
                            $old_value = $field->old;
                        }
                    }

                    if( !is_null($old_value) && strlen($old_value) && $old_value != 0 ) {
                        $description .= sprintf('<strong>%s</strong> from <span class="old-value">%s</span> to <span class="new-value">%s</span>', $class::$display_names[$field->field], $old_value, $new_value);
                    } else {
                        $description .= sprintf('<strong>%s</strong> to <span class="new-value">%s</span>', $class::$display_names[$field->field], $new_value);
                    }
                } else {

                    $description .= $event->eventable->object_type . '<br/>';
                }
            }
        }

        if( strlen($description) == 0 ) {
            $description = sprintf('updated %s', $event->eventable->object_type);
        }

        return $description;
    }
}