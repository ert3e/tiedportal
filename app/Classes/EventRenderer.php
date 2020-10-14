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

class EventRenderer
{
    public function title($event) {

        $description = '';

        switch( $event->event_class ) {

            case 'created':
            {
                $description = sprintf('created a %s', $event->eventable->object_type);
                break;
            }

            case 'updated':
            {
                $description = sprintf('updated a %s', $event->eventable->object_type);
                break;
            }

            case 'deleted':
            {
                $description = sprintf('deleted a %s', $event->eventable->object_type);
                break;
            }

            case 'conversion':
            {
                $description = sprintf('converted a %s', $event->eventable->object_type);
                break;
            }

            case 'completed':
            {
                $description = sprintf('completed a %s', $event->eventable->object_type);
                break;
            }

            case 'verified':
            {
                $description = sprintf('verified a %s', $event->eventable->object_type);
                break;
            }
        }

        return $description;
    }

    public function description($event) {

        if( $event->event_class == 'deleted' )
            return false;

        if( $event->event_class == 'updated' ) {

            $description = \TimelineRenderer::description($event);
        } else {
            $description = false;
            $object = $event->eventable;

            if( is_string($object->description) ) {
                $description = nl2br($object->description);
            }
        }

        return $description;
    }
}