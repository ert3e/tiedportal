@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('permissions', 'create') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-role-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Role</a>
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
            <p>{{ trans('roles.welcome') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Description</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $roles as $role )
                                <tr>
                                    <td>
                                        {!! $role->name !!}
                                    </td>

                                    <td>
                                        {!! $role->description !!}
                                    </td>
                                    <td>
                                        <a href="{!! route('roles.details', $role->id) !!}" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
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
        @embed('fragments.page.modal', ['id' => 'add-role-modal', 'route' => 'roles.store', 'files' => false, 'title' => 'Add Role', 'button' => trans('global.save')])

            @section('content')

                @macro('text_title', 'name', 'Role name')
                @macro('textarea_title', 'description', 'Role description')

            @endsection

        @endembed
    @endif

@endsection