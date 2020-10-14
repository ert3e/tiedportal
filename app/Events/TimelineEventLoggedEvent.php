<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TimelineEventLoggedEvent extends Event
{
    use SerializesModels;

    private $event;

    public function getEvent() {
        return $this->event;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
