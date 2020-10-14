<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class SendQuoteRequestQuotedEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $quote_request;
    private $quote;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($quote_request, $quote)
    {
        $this->quote_request = $quote_request;
        $this->quote = $quote;
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
            'quote'         => $this->quote
        ];

        Mail::send('emails.supplier.quoted', $data, function ($message) use($user) {
            $message->subject(sprintf('[QUOTE] %s', $this->quote_request->project->name));
            $message->to($user->email, sprintf('%s %s', $user->first_name, $user->last_name));
        });
    }
}
