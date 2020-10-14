@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('component-types', 'create') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-component-type-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Component Type</a>
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
            <p>{{ trans('component-types.welcome') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover mails m-0 table table-actions-bar">
                            <thead>
                            <tr>
                                <th>Colour</th>
                                <th>Component</th>
                                <th>Description</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $component_types as $component_type )
                                <tr>
                                    <td style="width: 80px"><div class="colour-display" style="background: #{{ $component_type->colour }};"></div></td>
                                    <td>
                                        {!! $component_type->name !!}
                                    </td>

                                    <td>
                                        {!! $component_type->description !!}
                                    </td>
                                    <td>
                                        <a href="{!! route('component-types.details', $component_type->id) !!}" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    @if( Permissions::has('permissions', 'create') )
        @embed('fragments.page.modal', ['id' => 'add-component-type-modal', 'route' => 'component-types.store', 'files' => false, 'title' => 'Add Role', 'button' => trans('global.save')])

            @section('content')

                @macro('colour_title', 'colour', 'Component type colour')
                @macro('text_title', 'name', 'Component type name')
                @macro('textarea_title', 'description', 'Component type description')

            @endsection

        @endembed
    @endif

@endsection