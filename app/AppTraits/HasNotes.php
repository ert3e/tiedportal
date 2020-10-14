<?php namespace App\AppTraits;

use App\Events\NoteAddedEvent;
use App\Models\Note;
use App\Models\Project;
use App\Models\Task;
use \DB;
use \Auth;
use Illuminate\Http\Request;

trait HasNotes {

    public function addNote(Request $request, $object) {

        $rules = [
            'note'   => 'required'
        ];

        $this->validate($request, $rules);
        // dd($request->input('type'));
        $note = DB::transaction(function() use($request, $object) {
            $note = new Note([
                'content'   => htmlentities($request->input('note')),
                'type'      => $request->input('type')
            ]);

            $note->user()->associate(Auth::user())->save();
            $object->notes()->save($note);

            return $note;
        });

        // TODO: Add timeline event

        \Event::fire(new NoteAddedEvent($object, $note, Auth::user()));

        if( $request->ajax() ) {
            return response()->json(['success' => true, 'note' => view('fragments.notes.note', compact('note'))->render()]);
        }

        return redirect()->back()->with('message', 'Note added!');
    }

    public function searchNotes(Request $request, $object)
    {
        $type = $request->get('type', null);
        $search = $request->get('search', null);
        $notes = $object->notes();
        if($type && $type != 'all' ){
            $notes->where('type', $type);
        }

        if($search && trim($search) != '' ){
            $notes->where('content', 'like', '%'.$search.'%');
        }
        $notes = $notes->get();
        if( $request->ajax() ) {
            return response()->json(['success' => true, 'html' => view('fragments.notes.ajax', compact('notes'))->render()]);
        }

        return view('fragments.notes.notes', compact('notes'));
    }
}
