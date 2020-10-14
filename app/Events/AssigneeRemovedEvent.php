<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AssigneeRemovedEvent extends Event
{
    use SerializesModels;

    private $object;
    private $assignee;
    private $assigner;

    public function getObject() {
        return $this->object;
    }

    public function getAssignee() {
        return $this->assignee;
    }

    public function getAssigner() {
        return $this->assigner;
    }
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($object, $assignee, $assigner)
    {
        $this->object = $object;
        $this->assignee = $assignee;
        $this->assigner = $assigner;
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
