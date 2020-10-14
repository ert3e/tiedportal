@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('permissions', 'delete') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#" title="Delete" data-title="Delete Role" data-message="Are you sure you want to delete this role? This action cannot be undone!" data-confirm="Role deleted!" data-redirect="{{ route('roles.index') }}" data-href="{{ route('roles.delete', ['id' => $role->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Role</a>
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
            <p>{{ trans('permissions.title') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['route' => ['roles.update', $role->id]]) !!}
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-hover mails m-0 table table-actions-bar">
                                    <thead>
                                    <tr>
                                        <th>Permission Type</th>
                                        @foreach( $permissions as $permission )
                                            <th class="td-checkbox">{!! trans('permissions.'.$permission) !!}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $permissions_groups as $group => $available_permissions )
                                        <tr>
                                            <td>
                                                {!! trans('permissiongroups.'.$group) !!}
                                            </td>
                                            @foreach( $permissions as $key => $permission )
                                                <td class="td-checkbox">
                                                    @if( in_array($permission, $available_permissions) )
                                                        {!! Form::checkbox('permission['.$group.'][]', $key, $role->has($group, $key), ['class' => 'js-switch', 'data-size' => 'small', 'data-plugin' => 'switchery']) !!}
                                                    @else
                                                        {!! Form::checkbox('', '', false, ['class' => 'js-switch', 'data-size' => 'small', 'data-plugin' => 'switchery', 'data-disabled' => 'true']) !!}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 m-t-20">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div> <!-- end col -->
    </div>

@endsection