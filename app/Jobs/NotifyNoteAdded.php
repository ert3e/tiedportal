<?php

namespace App\Jobs;

use App\Events\NoteAddedEvent;
use App\Jobs\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Mail;

class NotifyNoteAdded extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(NoteAddedEvent $event)
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
        $object = $this->event->getObject();
        $note = $this->event->getNote();
        $sender = $this->event->getSender();

        $data = [
            'object'    => $object,
            'note'      => $note,
            'sender'    => $sender
        ];

        $notify_functions = $object->notifyUsers();

        $recipients = [];
        foreach( $notify_functions as $function ) {
            $users = $object->$function;

            if( $users instanceof Collection ) {
                foreach( $users as $user ) {
                    if( $user instanceof User ) {
                        if( $user->id != $sender->id )
                            $recipients[] = $user;
                    }
                }
            }

            if( $users instanceof User ) {
                if( $users->id != $sender->id )
                    $recipients[] = $users;
            }
        }

        // We now have a collection of users to send the email to.
        $recipients = collect($recipients);

        Mail::send('emails.note.added', $data, function ($message) use($recipients, $object) {
            $message->to($recipients->pluck('email')->toArray());
            $message->subject(sprintf('[NOTE] [%s] %s', strtoupper($object->object_type), $object->displayName()));
        });
    }
}
