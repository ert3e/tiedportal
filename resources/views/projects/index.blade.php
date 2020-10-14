@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('projects', 'create') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-project-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add {{ ucwords($type) }}</a>
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
                        <div class="col-sm-6">
                            <div class="form-group contact-search">
                                <input type="text" name="search" class="form-control autosubmit delayed" placeholder="Search..." value="{{ $term }}">
                                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('owner', $owner_options, $owner, ['class' => 'form-control autosubmit']) !!}
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
                            <th>Name</th>
                            <th class="hidden-xs">Company</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th class="hidden-xs">Type(s)</th>
                            @if( Permissions::has('finance', 'view') )
                                <th class="hidden-xs text-right">Value</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $projects as $project )
                            <tr>
                                <td>
                                    <a href="{!! route('projects.details', $project->id) !!}">{{ $project->name }}
                                    @if( $project->children()->count() )
                                        <span class="badge badge-default">{{ $project->children()->count() }}</span>
                                    @endif
                                    </a>
                                </td>
                                <td class="hidden-xs">
                                    @if( is_object($project->customer) )
                                        <a href="{!! route('customers.details', $project->customer->id) !!}">{{ $project->customer->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if( $project->scope == 'external' )
                                            <span class="label label-info">EXTERNAL</span>
                                    @else
                                            <span class="label label-warning">INTERNAL</span>
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if( $project->status == 'prospect' || $project->status == 'lost' )
                                        @if( is_object($project->prospectStatus) )
                                            <span class="label" style="background-color:#{{ $project->prospectStatus->colour }}">{{ $project->prospectStatus->name }}</span>
                                        @else
                                            <span class="label label-danger">None</span>
                                        @endif
                                    @else
                                        @if( is_object($project->projectStatus) )
                                            <span class="label" style="background-color:#{{ $project->projectStatus->colour }}">{{ $project->projectStatus->name }}</span>
                                        @else
                                            <span class="label label-danger">None</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @foreach( $project->types as $project_type )
                                        <span class="label label-default">{{ $project_type->name }}</span>
                                    @endforeach
                                </td>
                                @if( Permissions::has('finance', 'view') )
                                    <td class="hidden-xs text-right">
                                        {{ FieldRenderer::formatCurrency($project->costs()->sum('value')) }}
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $projects->links() !!}
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    @if( Permissions::has('projects', 'create') )
        @embed('fragments.page.modal', ['id' => 'add-project-modal', 'route' => 'projects.store', 'files' => false, 'title' => 'Add ' . ucwords($type), 'button' => trans('global.save')])

            @section('content')
                {!! Form::hidden('status', $type) !!}
                @macro('typeahead_title', 'customer_id', route('customers.autocomplete'), 'Company', true)
                @macro('text_title', 'name', ucwords($type) . ' name', true)
                @macro('select_title', 'lead_source_id', $lead_sources, ucwords($type) . ' source', true)
                @macro('select_title', 'scope', ['external' => 'external', 'internal' => 'internal'], ucwords($type) . ' scope', true)
                @macro('textarea_title', 'description', ucwords($type) . ' description')
            @endsection

        @endembed
    @endif

@endsection
