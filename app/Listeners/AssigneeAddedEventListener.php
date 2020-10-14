<?php

namespace App\Listeners;

use App\Events\AssigneeAddedEvent;
use App\Interfaces\NotifiesEvents;
use App\Jobs\NotifyAssigneeAdded;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssigneeAddedEventListener
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
    public function handle(AssigneeAddedEvent $event)
    {
        $this->dispatch(new NotifyAssigneeAdded($event));
    }
}
