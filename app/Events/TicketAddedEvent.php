<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketAddedEvent extends Event
{
    use SerializesModels;

    private $ticket;

    public function getTicket() {
        return $this->ticket;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
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
