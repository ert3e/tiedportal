@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('tasks', 'create') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-task-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Task</a>
                </li>
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <form role="form" method="GET">
                    <div class="row m-b-30">
                        <div class="col-sm-12">
                            <div class="form-group contact-search">
                                <input type="text" name="search" class="form-control autosubmit delayed" placeholder="Search..." value="{{ $term }}">
                                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('owner', $owner_options, $owner, ['class' => 'form-control autosubmit']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('show', $show_options, $show, ['class' => 'form-control autosubmit']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('type', $types, $type, ['class' => 'form-control autosubmit']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('status', $statuses, $status, ['class' => 'form-control autosubmit']) !!}
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="empty-note-priority">Title</th>
                            <th class="hidden-xs">Project</th>
                            <th class="hidden-xs">Customer</th>
                            <th class="hidden-xs">Assignee(s)</th>
                            <th class="hidden-xs">Type</th>
                            <th>Priority</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $tasks as $task )
                            <tr title="{{$task->verbal_priority}} priority">
                                <td class="{{strtolower($task->verbal_priority)}}-note-priority">
                                    <a href="{!! route('tasks.details', $task->id) !!}">{{ $task->title }}
                                    @if( $task->children()->count() )
                                        <span class="badge badge-default">{{ $task->children()->count() }}</span>
                                    @endif
                                    </a>
                                </td>
                                <td class="hidden-xs">
                                    @if( is_object($task->project) )
                                        <a href="{{ route('projects.details', $task->project->id) }}">{{ $task->project->name }}</a>
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if( is_object($task->project) && is_object($task->project->customer) )
                                        <a href="{{ route('customers.details', $task->project->customer->id) }}">{{ $task->project->customer->name }}</a>
                                    @else
                                        None
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
                                    {{ array_get(App\Models\Task::$priorities, $task->priority, 'Default') }}
                                </td>
                                <td>
                                    @if( is_object($task->taskStatus) )
                                        <span class="label label-default" style="background-color: #{{ $task->taskStatus->colour }}">{{ $task->taskStatus->name }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $tasks->links() !!}
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    @if( Permissions::has('tasks', 'create') )
        @embed('fragments.page.modal', ['id' => 'add-task-modal', 'route' => 'tasks.store', 'files' => false, 'title' => 'Add Task', 'button' => trans('global.save')])

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

@endsection
