<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use App\Http\Requests;

class NoteController extends Controller
{
    public function delete($note) {

        if( $note->user_id != Auth::user()->id )
            abort(401);

        $note->delete();

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $note) {

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
