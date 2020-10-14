<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;
use \FieldRenderer;

class SendProjectAssignedEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $project;
    private $assignee;
    private $assigner;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project, $assigner, $assignee)
    {
        $this->project = $project;
        $this->assigner = $assigner;
        $this->assignee = $assignee;
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
            'assigner'  => $this->assigner,
            'assignee'  => $this->assignee
        ];

        Mail::send('emails.projects.assigned', $data, function ($message) {
            $message->to($this->assignee->email, FieldRenderer::userDisplay($this->assignee));
            $message->subject('[PROJECT] ' . $this->project->name);
        });
    }
}
