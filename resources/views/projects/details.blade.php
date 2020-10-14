@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('projects', 'create') || Permissions::has('projects', 'delete') || Permissions::has('projects', 'edit') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                @if( Permissions::has('projects', 'create') )
                    <li>
                        <a href="#add-subproject-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add subproject</a>
                    </li>
                @endif
                @if( Permissions::has('projects', 'edit') )
                    <li>
                        <a href="#" title="Complete" data-title="Complete Project" data-message="Are you sure you want to mark this project as complete?" data-confirm="Project completed!" data-href="{{ route('projects.complete', ['id' => $project->id, '_token' => csrf_token()]) }}" class="success confirm-button"><i class="md md-check"></i> Complete project</a>
                    </li>
                @endif
                @if( Permissions::has('projects', 'delete') )
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Project" data-message="Are you sure you want to delete this project? This action cannot be undone!" data-confirm="Project deleted!" data-redirect="{{ route('projects.index') }}" data-href="{{ route('projects.delete', ['id' => $project->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="fa fa-trash"></i> Delete project</a>
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

    <div class="row filedrop" data-attach-url="{{ route('projects.attachments.attach', $project->id) }}" data-detach-url="{{ route('projects.attachments.detach', $project->id) }}" data-token="{{ csrf_token() }}">
        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">
                <li class="active tab">
                    <a href="#details" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Details</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#tasks" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-check-square-o"></i></span>
                        <span class="hidden-xs">Tasks</span>
                    </a>
                </li>
                @if ($project->scope == 'external')
                <li class="tab">
                    <a href="#components" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-cubes"></i></span>
                        <span class="hidden-xs">Components</span>
                    </a>
                </li>
                @endif
                @if( (Permissions::has('finance', 'view') || Permissions::has('finance', 'create')) && $project->scope == 'external' )
                    <li class="tab">
                        <a href="#finance" data-toggle="tab" aria-expanded="true">
                            <span><i class="fa fa-pie-chart"></i></span>
                            <span class="hidden-xs">Financials</span>
                        </a>
                    </li>
                @endif
                @if( Permissions::has('timeline', 'view') )
                    <li class="tab">
                        <a href="#timeline" data-toggle="tab" aria-expanded="false">
                            <span><i class="fa fa-clock-o"></i></span>
                            <span class="hidden-xs">Activity</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                <div id="details" class="tab-pane active">
                    @include('projects.fragments.details')
                </div>
                <div id="tasks" class="tab-pane">
                    @include('fragments.tasks.tasks', ['object' => $project, 'route' => ['projects.tasks.create', $project->id]])
                </div>
                @if( Permissions::has('finance', 'view') || Permissions::has('finance', 'create') )
                    <div id="finance" class="tab-pane" style="display: none;">
                        @include('projects.fragments.financials')
                    </div>
                @endif
                <div id="components" class="tab-pane" style="display: none;">
                    @include('projects.fragments.components')
                </div>
                @if( Permissions::has('timeline', 'view') )
                    <div id="timeline" class="tab-pane" style="display: none;">
                        <div class="card-box">
                            @include('fragments.timeline.index', ['object' => $project])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if( Permissions::has('projects', 'create') )
        @embed('fragments.page.modal', ['id' => 'add-subproject-modal', 'route' => 'projects.store', 'files' => false, 'title' => 'Add subproject', 'button' => trans('global.save')])

            @section('content')
                {!! Form::hidden('status', $project->status) !!}
                {!! Form::hidden('parent_id', $project->id) !!}
                {!! Form::hidden('customer_id', $project->customer_id) !!}
                @macro('text_title', 'name', 'Subproject name', true)
                @macro('textarea_title', 'description', 'Subproject description')
            @endsection

        @endembed
    @endif

    @if( $project->status == 'prospect' && Permissions::has('leads', 'edit') )

        @embed('fragments.page.modal', ['id' => 'convert-lead-modal', 'route' => ['projects.convert', $project->id], 'files' => false, 'title' => 'Convert lead', 'button' => trans('global.save')])

            @section('content')
                {!! Form::hidden('status', 'active') !!}
                @if( $project->children()->count() )
                    <p><strong>WARNING: This will update all subprojects!</strong></p>
                @endif
                @macro('select_title', 'conversion_reason_id', $conversion_reasons, 'Conversion reason', true)
            @endsection

        @endembed

        @embed('fragments.page.modal', ['id' => 'lost-lead-modal', 'route' => ['projects.convert', $project->id], 'files' => false, 'title' => 'Lost lead', 'button' => trans('global.save')])

            @section('content')
                {!! Form::hidden('status', 'lost') !!}
                @if( $project->children()->count() )
                    <p><strong>WARNING: This will update all subprojects!</strong></p>
                @endif
                @macro('select_title', 'conversion_reason_id', $loss_reasons, 'Lost reason', true)
            @endsection

        @endembed
    @endif

@endsection