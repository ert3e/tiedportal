<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoteAddedEvent extends Event
{
    use SerializesModels;

    private $object;
    private $note;
    private $sender;

    public function getObject() {
        return $this->object;
    }

    public function getNote() {
        return $this->note;
    }

    public function getSender() {
        return $this->sender;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($object, $note, $sender)
    {
        $this->object = $object;
        $this->note = $note;
        $this->sender = $sender;
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
