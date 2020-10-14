@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('users', 'create') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-user-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add User</a>
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
            <p>{{ trans('users.welcome') }}</p>
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
                                <th style="width: 100px"></th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th >Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $users as $user )
                                <tr>
                                    <td>
                                        <img src="{!! $user->imageUrl(100, 100) !!}" alt="{{ FieldRenderer::userDisplay($user) }}" title="{{ FieldRenderer::userDisplay($user) }}" class="thumb-sm" />
                                    </td>
                                    <td>
                                        {!! $user->username !!}
                                    </td>
                                    <td>
                                        {{ FieldRenderer::userDisplay($user) }}
                                    </td>
                                    <td>
                                        <a href="mailto:{!! $user->email !!}">{!! $user->email !!}</a>
                                    </td>
                                    <td>
                                        @if( is_object($user->role) )
                                            {{ $user->role->name }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td width="100px">
                                        <a href="{!! route('users.details', $user->id) !!}" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                                        <a href="#" title="Delete" data-title="Delete user" data-message="Are you sure you want to delete this user? This action cannot be undone!" data-confirm="User deleted!"  data-href="{{ route('users.delete', ['user' => $user->id, '_token' => csrf_token()]) }}" class="btn btn-danger delete-button"><i class="fa fa-trash"></i></a>
                                        {{-- <form action="{{ route('users.delete', $user->id) }}" method="post" class="inline-block">
                                            {{ csrf_field() }}
                                            <input type='hidden' name='_method' value="delete">
                                            {{-- <button  onclick="return confirm('Are you sure?')" class="btn btn-danger">
                                            <button data-title="Remove user" data-message="Are you sure you want to remove this user?" data-confirm="User removed!" data-href="" class="btn btn-danger confirm-button">
                                            {{-- <button  class="btn btn-danger confirm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form> --}}

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

    @if( Permissions::has('users', 'create') )
        @embed('fragments.page.modal', ['id' => 'add-user-modal', 'route' => 'users.store', 'files' => false, 'title' => 'Add User', 'button' => trans('global.save')])

            @section('content')

                <div class="col-sm-6">
                    @macro('text_title', 'username', 'Username', true)
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'email', 'Email address', true)
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'first_name', 'First name', true)
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'last_name', 'Last name', true)
                </div>
                <div class="col-sm-12">
                    @macro('checkbox', 'generate_password', 'Generate password and email user', true)
                </div>

            @endsection

        @endembed
    @endif

@endsection
