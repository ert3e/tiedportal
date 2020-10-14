<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;
use \FieldRenderer;

class SendProjectNoteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $project;
    private $sender;
    private $note;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project, $note, $sender)
    {
        $this->project = $project;
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
            'project'   => $this->project,
            'note'      => $this->note,
            'sender'    => $this->sender
        ];

        $recipients = [];

        foreach( $this->project->assignees as $user ) {
            if( $user->id != $this->sender->id )
                $recipients[] = $user->email;
        }

        if( $this->project->user->id != $this->sender->id )
            $recipients[] = $this->project->user->email;

        Mail::send('emails.projects.note', $data, function ($message) use($recipients) {
            $message->to($recipients);
            $message->subject('[PROJECT] ' . $this->project->name);
        });
    }
}
