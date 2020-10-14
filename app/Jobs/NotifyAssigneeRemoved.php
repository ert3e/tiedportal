<?php

namespace App\Jobs;

use App\Events\AssigneeRemovedEvent;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class NotifyAssigneeRemoved extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AssigneeRemovedEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $object = $this->event->getObject();
        $assignee = $this->event->getAssignee();
        $assigner = $this->event->getAssigner();

        $data = [
            'object'    => $object,
            'assignee'  => $assignee,
            'assigner'  => $assigner
        ];

        Mail::send('emails.assignee.removed', $data, function ($message) use($assignee, $object) {
            $message->to($assignee->email);
            $message->subject(sprintf('[UNASSIGNED] [%s] %s', strtoupper($object->object_type), $object->displayName()));
        });
    }
}
