<div class="card-box note-container">
    @if( Permissions::has('projects', 'edit') && Permissions::has('tasks', 'create') )
        <div class="btn-group pull-right">
            <a href="#create-task-modal" class="btn btn-default dropdown-toggle waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-target="#modal-container" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Task</a>
        </div>
    @endif
    <h4 class="m-t-0 m-b-30 header-title"><b>Tasks</b></h4>
    @if( $object->tasks()->count() )
        <table class="table table-hover mails m-0 table table-actions-bar">
            <thead>
            <tr>
                <th>Title</th>
                <th class="hidden-xs">Assignee(s)</th>
                <th class="hidden-xs">Type</th>
                <th>Status</th>
                <th>State</th>
                <th style="width: 5%">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach( $object->tasks as $task )
                <tr title="{{$task->verbal_priority}} priority">
                    <td class="{{strtolower($task->verbal_priority)}}-note-priority">
                        {{ $task->title }}
                        @if( $task->children()->count() )
                            <span class="badge badge-default">{{ $task->children()->count() }}</span>
                        @endif
                    </td>
                    <td class="hidden-xs">
                        {!!  FieldRenderer::users($task->assignees) !!}
                    </td>
                    <td class="hidden-xs">
                        @if( is_object($task->taskType) )
                            <span class="label label-default" style="background-color: #{{ $task->taskType->colour }}">{{ $task->taskType->name }}</span>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if( is_object($task->taskStatus) )
                            <span class="label label-default" style="background-color: #{{ $task->taskStatus->colour }}">{{ $task->taskStatus->name }}</span>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{ ucwords($task->status) }}
                    </td>
                    <td>
                        <a href="{!! route('tasks.details', $task->id) !!}" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p><em>No tasks</em></p>
    @endif
</div>

@if( Permissions::has('projects', 'edit') && Permissions::has('tasks', 'create') )
    @embed('fragments.page.modal', ['id' => 'create-task-modal', 'route' => $route, 'files' => false, 'title' => 'Add Task', 'button' => trans('global.save')])

        @section('content')
            @macro('text_title', 'title', 'Task title', true)
            @macro('checkbox_title', 'private', 'Privacy', false, false, 'Set to private (only assigned users will see this task)')
            @macro('select_title', 'type', $task_types, 'Type', false)
            @macro('select_title', 'priority', $priorities, 'Priority', false, 2)
            @macro('textarea_title', 'description', 'Description', false)
            @macro('typeahead_title', 'assignee', route('users.autocomplete'), 'Assignee', false)
        @endsection

    @endembed
@endif
