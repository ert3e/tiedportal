<?php

namespace App\Jobs;

use App\Events\AssigneeAddedEvent;
use App\Events\TicketAddedEvent;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class NotifyTicketAdded extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TicketAddedEvent $event)
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
        $ticket = $this->event->getTicket();

        $data = [
            'ticket'    => $ticket,
            'content'   => $ticket->notes()->orderBy('created_at', 'DESC')->first()->content
        ];

        $recipients = [];

        if( is_object($ticket->project) ) {
            if( is_object($ticket->project->user) )
                $recipients[] = $ticket->project->user->email;

            $recipients += $ticket->project->assignees()->pluck('email')->all();
        }

        Mail::send('emails.ticket.added', $data, function ($message) use($recipients, $ticket) {
            $message->to($recipients);
            $message->subject(sprintf('[TICKET] [ADDED] %s', $ticket->subject));
        });

        Mail::send('emails.ticket.confirm', $data, function ($message) use($ticket) {
            $message->to($ticket->user->contact->email);
            $message->subject(sprintf('[TICKET] [ADDED] %s', $ticket->subject));
        });
    }
}
