<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class NotifyChangeEvent extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event)
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
        $object = $this->event->eventable;

        if( !is_object($object) )
            return;

        $notify_functions = $object->notifyUsers();

        $recipients = [];
        foreach( $notify_functions as $function ) {
            $users = $object->$function;

            if( $users instanceof Collection ) {
                foreach( $users as $user ) {
                    if( $user instanceof User ) {
                        if( $user->id != $this->event->user->id )
                            $recipients[] = $user;
                    }
                }
            }

            if( $users instanceof User ) {
                if( $users->id != $this->event->user->id )
                    $recipients[] = $users;
            }
        }

        // We now have a collection of users to send the email to.
        $data = [
            'event'         => $this->event
        ];

        $recipients = collect($recipients)->filter(function($object) {
            return strlen($object->email);
        });

        Mail::send('emails.events.event', $data, function ($message) use($recipients) {
            $message->to($recipients->pluck('email')->toArray());
            $message->subject(sprintf('[%s] %s', strtoupper($this->event->eventable->object_type), $this->event->eventable->displayName()));
        });
    }
}
