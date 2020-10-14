@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('tasks', 'create') || Permissions::has('tasks', 'delete') || Permissions::has('tasks', 'edit') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                {{-- @if( Permissions::has('tasks', 'create') )
                    <li>
                        <a href="#add-subtask-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Subtask</a>
                    </li>
                    <li class="divider"></li>
                @endif --}}
                @if( Permissions::has('tasks', 'delete') )
                    <li>
                        <a href="#" title="Delete" data-title="Delete Task" data-message="Are you sure you want to delete this task? This action cannot be undone!" data-confirm="Task deleted!" data-redirect="{{ route('tasks.index') }}" data-href="{{ route('tasks.delete', ['id' => $task->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Task</a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    @macro('messages')

    <div class="row filedrop" data-attach-url="{{ route('tasks.attachments.attach', $task->id) }}" data-detach-url="{{ route('tasks.attachments.detach', $task->id) }}" data-token="{{ csrf_token() }}">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Task</b></h4>
                <div class="col-lg-12">
                    @macro('editable_select', 'tasks', 'status', $statuses, 'Status', $task->status, route('tasks.update', $task->id))
                </div>
                <div class="col-lg-12">
                    @macro('editable_select', 'tasks', 'priority', $priorities, 'Priority', $task->priority, route('tasks.update', $task->id))
                </div>
                <div class="col-lg-12">
                    @macro('editable_select', 'tasks', 'private', $visibilities, 'Visibility', $task->private, route('tasks.update', $task->id))
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>People</b></h4>
                <div class="form-group">
                    <label for="name">
                        Creator
                    </label>
                    <ul style="overflow: hidden;" class="list-unstyled assignee-list nicescroll" tabindex="5001">
                        <li>
                            <img src="{!! $task->user->imageUrl(60, 60) !!}" alt="{{ FieldRenderer::userDisplay($task->user) }}" title="{{ FieldRenderer::userDisplay($task->user) }}" class="thumb-sm" />
                            <span class="tran-text">{!! FieldRenderer::user($task->user) !!}</span>
                        </li>
                    </ul>
                </div>
                @include('fragments.users.assignees', ['object' => $task, 'add_url' => route('tasks.assignees.add', $task->id), 'remove_url' => route('tasks.assignees.remove', $task->id)])
            </div>

        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="col-lg-6">
                    @macro('editable_text', 'tasks', 'title', 'Title', $task->title, route('tasks.update', $task->id))
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        @if( is_object($project) )
                            <label for="company">Projects</label>
                            <div class="editable-container"><span class="edit-parent-span"><a href="{!! route('projects.details', $project->id) !!}">{{ $project->name }}</a></span></div>
                        @else
                            @include('fragments.projects.assignee', ['object' => $task, 'add_url' => route('tasks.project.assignee', $task->id), 'remove_url' => ''])
                            {{-- <div class="editable-container"><span class="edit-parent-span">N/A</span></div> --}}
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    @macro('editable_select', 'tasks', 'task_type_id', $types, 'Type', $task->taskType, route('tasks.update', $task->id))
                </div>
                <div class="col-lg-6">
                    @macro('editable_select', 'tasks', 'task_status_id', $task_statuses, 'Status', $task->taskStatus, route('tasks.update', $task->id))
                </div>

                <div class="col-lg-12">
                    @macro('editable_textarea', 'tasks', 'description', 'Description', $task->description, route('tasks.update', $task->id))
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Dates</b></h4>
                <div class="col-lg-3">
                    @macro('editable_date', 'tasks', 'start_date', 'Start Date', $task->start_date, route('tasks.update', $task->id))
                </div>
                <div class="col-lg-3">
                    @macro('editable_date', 'tasks', 'due_date', 'Due Date', $task->due_date, route('tasks.update', $task->id))
                </div>

                <div class="col-lg-3">
                    @macro('label_title', 'Created', FieldRenderer::formatDate($task->created_at, true))
                </div>
                <div class="col-lg-3">
                    @macro('label_title', 'Updated', FieldRenderer::formatDate($task->updated_at, true))
                </div>
                <div class="clearfix"></div>
            </div>

            @include('fragments.media.attachments', ['object' => $task])

            @include('fragments.notes.notes', ['route' => ['tasks.notes.add', $task->id], 'search_route' => ['tasks.notes.search', $task->id]])

            @if( Permissions::has('timeline', 'view') )
                <div class="card-box">
                    @include('fragments.timeline.index', ['object' => $task])
                </div>
            @endif
        </div>

    </div>

@endsection
