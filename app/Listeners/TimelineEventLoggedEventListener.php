<?php

namespace App\Listeners;

use App\Events\TimelineEventLoggedEvent;
use App\Interfaces\NotifiesEvents;
use App\Jobs\NotifyChangeEvent;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Event;

class TimelineEventLoggedEventListener
{
    use DispatchesJobs;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TimelineEventLoggedEvent  $event
     * @return void
     */
    public function handle(TimelineEventLoggedEvent $e)
    {
        $event = $e->getEvent();

        $eventable = $event->eventable;

        // We're only interested in objects that implement NotifiesEvents
        if( !($eventable instanceof NotifiesEvents) )
            return;

        $this->dispatch(new NotifyChangeEvent($event));
    }
}
