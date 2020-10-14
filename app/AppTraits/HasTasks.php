<?php namespace App\AppTraits;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use \DB;
use \Auth;
use App\Models\User;

trait HasTasks
{
    public function createTask(Request $request, $object = false) {

        $rules = [
            'title'     => 'required',
            'assignee'  => 'exists:users,id'
        ];

        $this->validate($request, $rules);

        $task = DB::transaction(function() use($request, $object) {

            $task = new Task([
                'title'         => $request->input('title', ''),
                'description'   => $request->input('description', ''),
                'task_type_id'  => $request->input('type', ''),
                'priority'      => $request->input('priority', 2), // Normal
                'private'       => $request->input('private', false),
                'status'        => 'open'
            ]);

            $task->user()->associate(Auth::user())->save();

            if( $object ) {
                $object->tasks()->save($task);
            }

            if( $request->has('assignee') ) {
                $task->assignees()->attach($request->input('assignee'));

                $assignee = User::find($request->input('assignee'));

                // TODO: Add timeline event
            } else {

                $assignee = Auth::user();
                $task->assignees()->attach($assignee);

                // TODO: Add timeline event
            }

            return $task;
        });

        if( $request->ajax() ) {
            return response()->json(['success' => true, 'task' => view('fragments.tasks.task', compact('task'))->render()]);
        }

        return redirect()->route('tasks.details', $task->id);
    }
}
