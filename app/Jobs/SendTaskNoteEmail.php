<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;
use \FieldRenderer;

class SendTaskNoteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $task;
    private $sender;
    private $note;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($task, $note, $sender)
    {
        $this->task = $task;
        $this->note = $note;
        $this->sender = $sender;
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
            'note'      => $this->note,
            'sender'    => $this->sender
        ];

        $recipients = [];

        foreach( $this->task->assignees as $user ) {
            if( $user->id != $this->sender->id )
                $recipients[] = $user->email;
        }

        if( $this->task->user->id != $this->sender->id )
            $recipients[] = $this->task->user->email;

        Mail::send('emails.tasks.note', $data, function ($message) use($recipients) {
            $message->to($recipients);
            $message->subject('[TASK] ' . $this->task->name);
        });
    }
}
