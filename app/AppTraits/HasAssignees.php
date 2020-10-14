<?php namespace App\AppTraits;

use App\Events\AssigneeAddedEvent;
use App\Events\AssigneeRemovedEvent;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use \DB;
use \Auth;

trait HasAssignees
{
    public function addAssignee(Request $request, $object) {

        $rules = [
            'user_id'   => 'required|exists:users,id'
        ];

        $this->validate($request, $rules);

        $assignee = User::find($request->input('user_id'));

        if( $object->assignees()->where('id', $assignee->id)->count() ) {
            return response()->json(['success' => false, 'message' => 'User already assigned']);
        }

        $object->assignees()->attach($assignee);

        // TODO: Add timeline event

        \Event::fire(new AssigneeAddedEvent($object, $assignee, Auth::user()));

        if( $request->ajax() ) {
            return response()->json(['success' => true, 'user' => view('fragments.users.assignee', compact('assignee'))->render()]);
        }

        return redirect()->back()->with('message', 'Assignee added!');
    }

    public function removeAssignee(Request $request, $object) {

        $rules = [
            'user_id'   => 'required|exists:users,id'
        ];

        $this->validate($request, $rules);

        $assignee = User::find($request->input('user_id'));

        $object->assignees()->detach($assignee);

        // TODO: Add timeline event

        \Event::fire(new AssigneeRemovedEvent($object, $assignee, Auth::user()));

        if( $request->ajax() ) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('message', 'Assignee added!');
    }
}