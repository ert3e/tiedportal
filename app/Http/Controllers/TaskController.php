<?php

namespace App\Http\Controllers;

use App\AppTraits\HasAssignees;
use App\AppTraits\HasAttachments;
use App\AppTraits\HasEditableAttributes;
use App\AppTraits\HasNotes;
use App\AppTraits\HasTasks;
use App\AppTraits\UploadsMedia;
use App\Jobs\SendTaskClosedEmail;
use App\Jobs\SendTaskNoteEmail;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Http\Request;
use \Breadcrumbs;
use App\Http\Requests;

class TaskController extends Controller
{
    use HasNotes;
    use UploadsMedia;
    use HasTasks;
    use HasAssignees;
    use HasAttachments;
    use HasEditableAttributes;

    public function index(Request $request) {

        Breadcrumbs::push(trans('tasks.title'), route('tasks.index'));

        $term = '';
        $status = $request->input('status', '');
        $type = $request->input('type', '');
        $show = $request->input('show', 'open');
        $owner = $request->input('owner', 'assigned');

        if( $request->has('search') ) {

            $term = $request->get('search');
            $tasks = Task::visible()->where('title', 'LIKE', '%' . $term . '%');

        } else {
            $tasks = Task::visible()->where('parent_id', 0);
        }

        if( $owner == 'all' ) {
        } else if( $owner == 'mine' ) {
            $tasks->mine();
        } else if( $owner == 'assigned' ) {
            $tasks->assigned();
        } else {
            $tasks->assigned($owner);
            // $tasks->where("user_id", $owner);
        }

        if( $show == 'open' )
            $tasks->open();

        if( is_numeric($status) ) {
            $tasks->where('task_status_id', $status);
        }

        if( is_numeric($type) ) {
            $tasks->where('task_type_id', $type);
        }

        $tasks = $tasks->orderBy('due_date', 'ASC')->orderBy('priority', 'DESC')->paginate(25)->appends($request->all());

        $types = ['' => 'Show all'] + TaskType::orderBy('name', 'ASC')->lists('name', 'id')->toArray();
        $statuses = ['' => 'Show all'] + TaskStatus::orderBy('name', 'ASC')->lists('name', 'id')->toArray();
        $show_options = ['open' => 'Open tasks', 'closed' => 'Include closed tasks'];
        $owner_options = ['mine' => 'Tasks I created', 'assigned' => 'Tasks I\'m asssigned to', 'all' => 'All tasks'];
        $task_types = ['' => 'None'] + TaskType::orderBy('name')->lists('name', 'id')->toArray();
        $priorities = Task::$priorities;

        $all = User::all();
        foreach($all as $u) {
            $owner_options[$u['id']] = "User: ".$u['username'];
        }

        return view('tasks.index', compact('tasks', 'term', 'type', 'status', 'types', 'statuses', 'show_options', 'show', 'owner_options', 'owner', 'task_types', 'priorities'));
    }

    public function details($task) {

        Breadcrumbs::push(trans('tasks.title'), route('tasks.index'));

        if( is_object($task->project) ) {
            Breadcrumbs::push($task->project->name, route('projects.details', [$task->project->id, '#tasks']));
        }

        Breadcrumbs::push($task->title, route('tasks.details', $task->id));

        $notes = $task->notes()->orderBy('created_at', 'DESC')->get();
        $types = TaskType::orderBy('name', 'ASC')->get();
        $task_statuses = TaskStatus::orderBy('name', 'ASC')->get();
        $priorities = Task::$priorities;
        $visibilities = [0 => 'Public', 1 => 'Private'];
        $statuses = ['open' => 'Open', 'closed' => 'Closed'];

        $project = false;
        if( $task->hasTaskable() && is_object($task->taskable) && is_a($task->taskable, Project::class) ) {
            $project = $task->taskable;
        }

        return view('tasks.details', compact('task', 'notes', 'types', 'statuses', 'priorities', 'visibilities', 'project', 'task_statuses', 'statuses'));
    }

    public function delete($task) {
        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function assigneeProject(Request $request, $task) {


        $rules = [
            'project_id'   => 'required|exists:projects,id'
        ];

        $this->validate($request, $rules);

        $project = Project::find($request->input('project_id'))->first();

        $project->tasks()->save($task);

        // \Event::fire(new AssigneeAddedEvent($object, $assignee, Auth::user()));

        if( $request->ajax() ) {
            return response()->json(['success' => true, 'project' => '<div class="editable-container"><span class="edit-parent-span"><a href="'.route('projects.details', $project->id).'">'. $project->name .'</a></span></div>']);
        }

        return redirect()->back()->with('message', 'Assignee added!');

        //
        //
        // if( $object->assignees()->where('id', $assignee->id)->count() ) {
        //     return response()->json(['success' => false, 'message' => 'User already assigned']);
        // }
        //
        // $object->assignees()->attach($assignee);
        //
        // // TODO: Add timeline event
        //
    }

}
