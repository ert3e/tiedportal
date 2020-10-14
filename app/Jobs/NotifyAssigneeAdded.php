<?php

namespace App\Jobs;

use App\Events\AssigneeAddedEvent;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class NotifyAssigneeAdded extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AssigneeAddedEvent $event)
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

        // No point in notifying yourself
        if( $assignee->id == $assigner->id )
            return;

        $data = [
            'object'    => $object,
            'assignee'  => $assignee,
            'assigner'  => $assigner
        ];

        Mail::send('emails.assignee.added', $data, function ($message) use($assignee, $object) {
            $message->to($assignee->email);
            $message->subject(sprintf('[ASSIGNED] [%s] %s', strtoupper($object->object_type), $object->displayName()));
        });
    }
}
