@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('component-types', 'edit') || Permissions::has('component-types', 'delete') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                @if( Permissions::has('component-types', 'edit') )
                    <li>
                        <a href="#add-field-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Field</a>
                    </li>
                @endif
                @if( Permissions::has('component-types', 'delete') )
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Component Type" data-message="Are you sure you want to delete this component type? This action cannot be undone!" data-confirm="Component deleted!" data-redirect="{{ route('component-types.index') }}" data-href="{{ route('component-types.delete', ['id' => $component_type->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Component Type</a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <p>{{ trans('component-types.details') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                @macro('editable_colour', 'component-types', 'colour', 'Colour', $component_type->colour, route('component-types.update', $component_type->id))
                @macro('editable_text', 'component-types', 'name', 'Name', $component_type->name, route('component-types.update', $component_type->id))
                @macro('editable_textarea', 'component-types', 'description', 'Description', $component_type->description, route('component-types.update', $component_type->id))
            </div>

            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover mails m-0 table table-actions-bar">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $component_type->fields as $field )
                                <tr>
                                    <td>
                                        {!! $field->name !!}
                                    </td>

                                    <td>
                                        {!! ucwords($field->type) !!}
                                    </td>

                                    <td>
                                        {!! $field->description !!}
                                    </td>

                                    <td>
                                        <a href="" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                                        <a href="#" title="Delete" data-title="Delete Field" data-message="Are you sure you want to delete this field? This action cannot be undone!" data-confirm="Field deleted!" data-redirect="{{ route('component-types.details', $component_type->id) }}" data-href="{{ route('component-types.fields.delete', ['id' => $component_type->id, $field->id, '_token' => csrf_token()]) }}" class="btn btn-danger waves-effect waves-light delete-button"><i class="md md-delete"></i></a>
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
        @embed('fragments.page.modal', ['id' => 'add-field-modal', 'route' => ['component-types.fields.store', $component_type->id], 'files' => false, 'title' => 'Add Field', 'button' => trans('global.save')])

        @section('content')

            @macro('text_title', 'name', 'Field name')
            @macro('select_title', 'type', $field_types, 'Field type')
            @macro('textarea_title', 'description', 'Field description')

        @endsection

        @endembed
    @endif

@endsection