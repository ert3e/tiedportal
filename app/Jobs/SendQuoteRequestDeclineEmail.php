<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class SendQuoteRequestDeclineEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $quote_request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($quote_request)
    {
        $this->quote_request = $quote_request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->quote_request->user;

        $data = [
            'quote_request' => $this->quote_request,
            'supplier'      => $this->quote_request->supplier,
            'project'       => $this->quote_request->project,
            'reason'        => $this->quote_request->supplier_message
        ];

        Mail::send('emails.supplier.declined', $data, function ($message) use($user) {
            $message->subject(sprintf('[DECLINED] %s', $this->quote_request->project->name));
            $message->to($user->email, sprintf('%s %s', $user->first_name, $user->last_name));
        });
    }
}
