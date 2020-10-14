@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    @macro('messages')

    <div class="row">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    @macro('editable_image', 'users', $user->imageUrl(200, 200), ['users.media.upload', $user->id])
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="col-sm-6">
                    @macro('editable_text', 'users', 'first_name', 'First name', $user->contact->first_name, route('contacts.update', $user->contact->id))
                </div>
                <div class="col-sm-6">
                    @macro('editable_text', 'users', 'last_name', 'Last name', $user->contact->last_name, route('contacts.update', $user->contact->id))
                </div>
                <div class="col-sm-6">
                    @macro('editable_text', 'users', 'username', 'Username', $user->username, route('users.update', $user->id))
                </div>
                <div class="col-sm-6">
                    @macro('editable_text', 'users', 'email', 'Email address', $user->email, route('users.update', $user->id))
                </div>
                @if( $user->type == 'user' )
                <div class="col-sm-6">
                    @if( $user->system_admin )
                        <div class="form-group">
                            <label for="name">Role</label>
                            <div class="editable-container">
                                <p><label class="text-danger">System Administrator</label></p>
                            </div>
                        </div>
                    @else
                        @macro('editable_select', 'users', 'role_id', $roles, 'Role', $user->role, route('users.update', $user->id))
                    @endif
                </div>
                @endif
                <div class="col-sm-6">
                    @macro('editable_password', $can_change_password, 'password', 'Change password', route('users.update', $user->id))
                </div>
                <div style="clear: both"></div>
            </div>

        </div>
    </div>

@endsection