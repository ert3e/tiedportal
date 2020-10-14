@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('contacts', 'delete') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#" title="Delete" data-title="Delete Contact" data-message="Are you sure you want to delete this contact? This action cannot be undone!" data-confirm="Contact deleted!" data-redirect="{{ route('contacts.index') }}" data-href="{{ route('contacts.delete', ['id' => $contact->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Contact</a>
                </li>
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    @macro('messages')

    <div class="row">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    @macro('editable_image', 'contacts', $contact->imageUrl(200, 200), ['contacts.media.upload', $contact->id])
                </div>
            </div>

            @if( is_object($contact->customer) )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Customer</b></h4>
                    <a href="{{ route('customers.details', $contact->customer->id) }}">{{ $contact->customer->name }}</a>
                </div>
            @endif

            @if( is_object($contact->supplier) )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Supplier</b></h4>
                    <a href="{{ route('suppliers.details', $contact->supplier->id) }}">{{ $contact->supplier->name }}</a>
                </div>
            @endif

            @if( is_object($contact->user) )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Login</b></h4>
                    <a href="{{ route('users.details', $contact->user->id) }}">{{ $contact->user->username }}</a>
                </div>
            @elseif( Permissions::has('users', 'create') )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Login</b></h4>
                    <button href="{{ route('contacts.user.create', [$contact->id]) }}" title="Edit" class="btn btn-default btn-block waves-effect waves-light" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
                            data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-plus"></i> Setup login</button>
                </div>
            @endif
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                {!! Form::model($contact, ['route' => ['contacts.update', $contact->id]]) !!}
                    <div class="row">
                        <div class="col-md-6">
                            @macro('editable_text', 'contacts', 'first_name', 'First name', $contact->first_name, route('contacts.update', $contact->id))
                        </div>
                        <div class="col-md-6">
                            @macro('editable_text', 'contacts', 'last_name', 'Last name', $contact->last_name, route('contacts.update', $contact->id))
                        </div>
                        <div class="col-md-6">
                            @macro('editable_text', 'contacts', 'telephone', 'Telephone', $contact->telephone, route('contacts.update', $contact->id))
                        </div>
                        <div class="col-md-6">
                            @macro('editable_text', 'contacts', 'email', 'Email', $contact->email, route('contacts.update', $contact->id))
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @macro('editable_textarea', 'contacts', 'description', 'Description', $contact->description, route('contacts.update', $contact->id))
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection