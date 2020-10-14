<?php

namespace App\Listeners;

use App\Events\AssigneeRemovedEvent;
use App\Jobs\NotifyAssigneeRemoved;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssigneeRemovedEventListener
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
     * @param  AssigneeRemovedEvent  $event
     * @return void
     */
    public function handle(AssigneeRemovedEvent $event)
    {
        $this->dispatch(new NotifyAssigneeRemoved($event));
    }
}
