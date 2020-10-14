<?php

namespace App\Listeners;

use App\Events\AssigneeAddedEvent;
use App\Events\TicketAddedEvent;
use App\Jobs\NotifyAssigneeAdded;
use App\Jobs\NotifyTicketAdded;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketAddedEventListener
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
     * @param  AssigneeAddedEvent  $event
     * @return void
     */
    public function handle(TicketAddedEvent $event)
    {
        $this->dispatch(new NotifyTicketAdded($event));
    }
}
