<?php

namespace App\Http\Controllers;

use App\AppTraits\UploadsMedia;
use App\Events\NoteAddedEvent;
use App\Models\Note;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Config;
use \DB;
use \Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    use UploadsMedia;

    protected function getMediaTypes() {
        return []; // Allow all types
    }

    public function inbox(Request $request) {

        $recipient = $request->input('recipient');
        $sender = $request->input('sender', '');
        $subject = $request->input('subject', '');
        $message = str_replace("\r\n", "\n", $request->input('stripped-text', ''));
        $date = Carbon::parse($request->input('Date'));

        $from_user = User::email($sender)->first();

        $json = json_encode($request->all());
        $file = storage_path() . '/mail/' . md5(time());
        file_put_contents($file, $json);

        // Which object is this for?
        $domain = Config::get('mail.domain');
        $object = false;
        if( preg_match("/[a-zA-Z]+[+]([a-z0-9]+)[@{$domain}]/", $recipient, $matches) ) {
            $destination = $matches[1];

            $type = substr($destination, 0, 1);
            $id = substr($destination, 1);

            switch( $type ) {

                case 'p':
                {
                    $object = Project::find($id);
                    break;
                }

                case 't':
                {
                    $object = Task::find($id);
                    break;
                }
            }
        }

        if( $object ) {

            Auth::login($from_user);

            DB::transaction(function() use($message, $object, $from_user) {
                $note = new Note([
                    'content'   => $message
                ]);

                $note->user()->associate($from_user)->save();
                $object->notes()->save($note);

                return $note;
            });

            if( method_exists($object, 'attachments') ) {

                $attachment_count = $request->input('attachment-count', 0);

                for( $i = 1; $i <= $attachment_count; $i++ ) {
                    $file_id = sprintf('attachment-%d', $i);

                    $media = $this->attachMedia($request, $file_id);

                    if( $media ) {
                        $object->attachments()->attach($media);
                    }
                }
            }

            Auth::logout();
        }

        return response('OK', 200);
    }

}
