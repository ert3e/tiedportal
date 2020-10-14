@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    @if( $tasks->count() )
        <div class="row">
            <div class="col-lg-12">

                <div class="portlet"><!-- /primary heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark text-uppercase">
                            My Tasks
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet2" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="empty-note-priority">Title</th>
                                        <th class="hidden-xs">Project</th>
                                        <th class="hidden-xs">Customer</th>
                                        <th class="hidden-xs">Due Date</th>
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
                                                @if( is_object($task->project) && is_object($task->project->customer) )
                                                    <a href="{{ route('customers.details', $task->project->customer->id) }}">{{ $task->project->customer->name }}</a>
                                                @else
                                                    None
                                                @endif
                                            </td>
                                            <td class="hidden-xs">
                                                @if( is_object($task->project) )
                                                    <a href="{{ route('projects.details', $task->project->id) }}">{{ $task->project->name }}</a>
                                                @else
                                                    None
                                                @endif
                                            </td>
                                            <td class="hidden-xs">
                                                {{ FieldRenderer::formatDate($task->due_date) }} {!! FieldRenderer::projectDue($task) !!}
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
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    @if( $tasks->hasMorePages() )
                                        <a href="{{ route('tasks.index') }}">View all tasks</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Current Projects
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="empty-prospect-status">Project Name</th>
                                    <th class="hidden-xs">Customer</th>
                                    <th class="hidden-xs">Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach( $projects as $project )
                                    {{-- {{dump($project)}} --}}
                                    <tr title="{{ucfirst($project->status)}}">
                                        <td class="{{strtolower($project->status)}}-prospect-status">
                                            <a href="{!! route('projects.details', $project->id) !!}">{{ $project->name }}</a></td>
                                        <td class="hidden-xs"><a href="{!! route('customers.details', $project->customer->id) !!}">{{ $project->customer->name }}</a></td>
                                        <td class="hidden-xs">{{ FieldRenderer::formatDate($project->start_date) }}</td>
                                        <td>{{ FieldRenderer::formatDate($project->due_date) }} {!! FieldRenderer::projectDue($project) !!}</td>
                                        <td>{!! FieldRenderer::projectStatus($project) !!}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @if( $projects->hasMorePages() )
                                    <a href="{{ route('projects.index', ['active']) }}">View all projects</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    @if( $events )
    <div class="row">
        <div class="col-lg-12">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Activity Feed
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="p-20">
                            <div class="timeline-2">
                                @foreach( $events as $event )
                                    <div class="time-item">
                                        <div class="item-info">
                                            <div class="text-muted">{!! TimelineRenderer::time($event) !!}</div>
                                            <p>
                                                {!! TimelineRenderer::user($event) !!} {!! TimelineRenderer::description($event) !!}
                                                @if( TimelineRenderer::url($event) )
                                                <a href="{{ TimelineRenderer::url($event) }}">view</a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
