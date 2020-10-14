<?php

namespace App\Listeners;

use App\Events\NoteAddedEvent;
use App\Interfaces\NotifiesEvents;
use App\Jobs\NotifyNoteAdded;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoteAddedEventListener
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
     * @param  NoteAddedEvent  $event
     * @return void
     */
    public function handle(NoteAddedEvent $event)
    {
        $object = $event->getObject();

        // We're only interested in objects that implement NotifiesEvents
        if( !($object instanceof NotifiesEvents) )
            return;

        $this->dispatch(new NotifyNoteAdded($event));
    }
}
