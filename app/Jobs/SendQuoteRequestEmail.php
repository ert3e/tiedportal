<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;
use \Hash;
use \DB;

class SendQuoteRequestEmail extends Job implements ShouldQueue
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
        $supplier = $this->quote_request->supplier;
        $project = $this->quote_request->project;

        $contact = $supplier->primaryContact;
        if( !is_object($contact) )
            $contact = $supplier->contacts()->first();

        // Not much to do without a contact.
        if( !is_object($contact) )
            return;

        $data = [
            'user'          => $contact->user,
            'contact'       => $contact,
            'project'       => $project,
            'supplier'      => $supplier,
            'quote_request' => $this->quote_request,
            'text'          => $this->quote_request->message
        ];

        Mail::send('emails.quote.request', $data, function ($message) use($contact) {
            $message->subject('Quote Request');
            $message->to($contact->email, sprintf('%s %s', $contact->first_name, $contact->last_name));
        });
    }
}
