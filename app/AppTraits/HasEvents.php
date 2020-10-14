<?php namespace App\AppTraits;

use App\Events\TimelineEventLoggedEvent;
use App\Models\Event;
use \DB;
use \Auth;

trait HasEvents {

    use Names;

    public $object_type = '';

    function __construct(array $attributes = array()) {
        parent::__construct($attributes);

        $this->object_type = strtolower(self::getBaseClassName());
    }

    protected function getLinkedEventModels() {
        return [];
    }

    public static function boot() {
        parent::boot();

        self::deleting(function($object) {

            if( in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(get_class($object))) )
                return;

            $event = DB::transaction(function() use($object) {
                $event = Event::create([
                    'event_class'   => 'deleted'
                ]);
                $event->eventable()->associate($object);
                Auth::user()->events()->save($event);

                return $event;
            });

            \Event::fire(new TimelineEventLoggedEvent($event));
        });

        self::updating(function($object) {

            $changed = $object->isDirty() ? $object->getDirty() : [];
            $original = $object->getOriginal();

            $metadata = [];
            foreach( $changed as $key => $change ) {
                $metadata[] = [
                    'field'     => $key,
                    'old'       => array_get($original, $key, null),
                    'new'       => $change
                ];
            }

            $event = DB::transaction(function() use($object, $changed, $metadata) {
                $event = Event::create([
                    'event_class'   => 'updated',
                    'metadata'      => ['fields' => $metadata]
                ]);
                $event->eventable()->associate($object);
                Auth::user()->events()->save($event);

                return $event;
            });

            \Event::fire(new TimelineEventLoggedEvent($event));
        });

        self::created(function($object) {

            $event = DB::transaction(function() use($object) {
                $event = Event::create([
                    'event_class'   => 'created'
                ]);
                $event->eventable()->associate($object);
                Auth::user()->events()->save($event);

                return $event;
            });

            \Event::fire(new TimelineEventLoggedEvent($event));
        });
    }

    public function getEventsAttribute() {

        $events = Event::where(function($q) {
            $q->where('eventable_type', get_class($this))
                ->where('eventable_id', $this->id);
        });

        foreach( $this->getLinkedEventModels() as $linked_model ) {

            $events->orWhere(function($q) use($linked_model) {
                $q->where('eventable_type', get_class($this->{$linked_model}()->getRelated()))
                    ->whereIn('eventable_id', $this->{$linked_model}->pluck('id')->toArray());
            });
        }

        return $events->orderBy('date', 'DESC')->get();
    }
}