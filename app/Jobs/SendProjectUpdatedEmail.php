<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;
use \FieldRenderer;

class SendProjectUpdatedEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $project;
    private $updater;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project, $updater)
    {
        $this->project = $project;
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
            'project'   => $this->project,
            'updater'   => $this->updater
        ];

        $recipients = [];

        foreach( $this->project->assignees as $user ) {
            if( $user->id != $this->updater->id )
                $recipients[] = $user->email;
        }

        if( $this->project->user->id != $this->updater->id )
            $recipients[] = $this->project->user->email;

        Mail::send('emails.projects.updated', $data, function ($message) use($recipients) {
            $message->to($recipients);
            $message->subject('[PROJECT] ' . $this->project->name);
        });
    }
}
