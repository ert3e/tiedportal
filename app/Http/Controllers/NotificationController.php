<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use App\Http\Requests;
use App\Models\Notification;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);

        return view('notifications.index', ['notifications' => $notifications] );
    }

    public function delete($notifi) {

        if( $notifi->user_id != Auth::user()->id )
            abort(401);

            $notifi->delete();

        return response()->json(['success' => true]);
    }


    public function store(Request $request)
    {
        $notifi = new Notification();
        $notifi->content = $request->get('content');
        $notifi->status = $request->get('status');
        $notifi->priority = $request->get('priority');
        $notifi->user_id = Auth::user()->id;
        $notifi->save();
        
        return redirect('notifications');
    }


    public function update(Request $request, $notifi) {

        // var_dump($note);
        if( $note->user_id != Auth::user()->id )
            abort(401);

            $content = trim($request->get('content',''));
            if($content == '') return response()->json(['success' => false]);
            $note->content = $content;
            $note->save();

        return response()->json(['success' => true]);
    }
}
