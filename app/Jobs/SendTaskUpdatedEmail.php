<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;
use \FieldRenderer;

class SendTaskUpdatedEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $task;
    private $updater;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($task, $updater)
    {
        $this->task = $task;
        $this->updater = $updater;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'task'      => $this->task,
            'updater'   => $this->updater
        ];

        $recipients = [];

        foreach( $this->task->assignees as $user ) {
            if( $user->id != $this->updater->id )
                $recipients[] = $user->email;
        }

        if( $this->task->user->id != $this->updater->id )
            $recipients[] = $this->task->user->email;

        Mail::send('emails.tasks.updated', $data, function ($message) use($recipients) {
            $message->to($recipients);
            $message->subject('[TASK] ' . $this->task->title);
        });
    }
}
