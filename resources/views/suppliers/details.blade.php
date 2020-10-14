@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('suppliers', 'edit') || Permissions::has('suppliers', 'delete')  )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-address-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Address</a>
                </li>
                <li>
                    <a href="#add-contact-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Contact</a>
                </li>
                <li>
                    <a href="#" title="Verify" class="confirm-button" data-title="Verify Supplier" data-message="Are you sure you want to verify this supplier? This action cannot be undone!" data-confirm="Supplier verified!" data-href="{{ route('suppliers.verify', ['id' => $supplier->id, '_token' => csrf_token()]) }}"><i class="md md-check"></i> Verify Supplier</a>
                </li>
                @if( Permissions::has('suppliers', 'delete') )
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Supplier" data-message="Are you sure you want to delete this supplier? This action cannot be undone!" data-confirm="Supplier deleted!" data-redirect="{{ route('suppliers.index') }}" data-href="{{ route('suppliers.delete', ['id' => $supplier->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Supplier</a>
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

    <div class="row">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    @if( is_object($supplier->media) )
                        @macro('editable_image', 'suppliers', route('media.get', [$supplier->media_id, 200, 200]), ['suppliers.media.upload', $supplier->id])
                    @else
                        @macro('editable_image', 'suppliers', '/img/generic-supplier.png', ['suppliers.media.upload', $supplier->id])
                    @endif
                </div>
            </div>

            @if( $supplier->contacts()->count() )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Contacts</b>
                        {{-- <a target="_blank" class="pull-right" href="{{route('suppliers.contacts.download', $supplier->id)}}" title="Download contacts"><i class="fa fa-download"></i></a> --}}
                    </h4>
                    <div class="inbox-widget" style="overflow: hidden;" tabindex="5001">
                        @foreach( $supplier->contacts as $contact )
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img alt="" class="img-circle" style="border: solid 2px #{{ is_object($contact->contactType) ?: '#fff' }}" src="{{ $contact->imageUrl() }}"></div>
                                <p class="inbox-item-author">{{ $contact->first_name }} {{ $contact->last_name }}</p>
                                <p class="inbox-item-text">
                                    @if( is_object($contact->contactType) )
                                        {{ $contact->contactType->name }}<br/>
                                    @endif
                                    @if( strlen($contact->telephone) )
                                        <i class="fa fa-mobile-phone"></i> {{ $contact->telephone }}<br/>
                                    @endif
                                    @if( strlen($contact->mobile) )
                                        <i class="fa fa-mobile-telephone"></i> {{ $contact->mobile }}<br/>
                                    @endif
                                    @if( strlen($contact->email) )
                                        <a href="mailto:{{ $contact->email }}"><i class="fa fa-envelope"></i> {{ $contact->email }}</a><br/>
                                    @endif
                                </p>
                                <p class="inbox-item-date">
                                    <a href="{{ route('contacts.details', $contact->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if( Permissions::has('timeline', 'view') )
                <div class="card-box">
                    @include('fragments.timeline.index', ['object' => $supplier])
                </div>
            @endif
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                @if( $supplier->verified )
                    <span class="pull-right label label-success"><i class="md md-check"></i> This supplier is verified</span>
                @else
                    <span class="pull-right label label-danger"><i class="md md-close"></i>This supplier is unverified</span>
                @endif
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="row">
                    <div class="col-md-6">
                        @macro('editable_text', 'suppliers', 'name', 'Name', $supplier->name, route('suppliers.update', $supplier->id))
                    </div>
                    <div class="col-md-6">
                        @macro('editable_text', 'suppliers', 'website', 'Website', $supplier->website, route('suppliers.update', $supplier->id))
                    </div>
                </div>
                @macro('editable_textarea', 'suppliers', 'description', 'Description', $supplier->description, route('suppliers.update', $supplier->id))
                @macro('editable_multiselect', 'suppliers', 'projectTypes', $project_types, 'Project Types', $supplier->projectTypes, route('suppliers.update', $supplier->id))
            </div>


            <div class="card-box">
                @foreach( $supplier->addresses as $address )
                    <h4 class="m-t-0 m-b-30 header-title"><b>Address(s)</b></h4>
                    <p><strong>{{ $address->name }}</strong> - {{ $address->asString() }}</p>
                @endforeach
            </div>

            @if( Permissions::has('projects', 'view') && $supplier->projects()->count() )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Projects</b></h4>
                    @foreach( $supplier->projects as $project )
                        <p><a href="{!! route('projects.details', $project->id) !!}">{{ $project->customer->name }} / {{ $project->name }}</a></p>
                    @endforeach
                </div>
            @endif

        </div>

        @embed('fragments.page.modal', ['id' => 'add-address-modal', 'route' => ['suppliers.address.store', $supplier->id], 'files' => false, 'title' => 'Add Address', 'button' => trans('global.save')])

            @section('content')

                @macro('text_title', 'name', 'Address name', true)
                @macro('text_title', 'address1', 'Address line 1', true)
                @macro('text_title', 'address2', 'Address line 2')
                @macro('text_title', 'town', 'Town')
                @macro('text_title', 'county', 'County')
                @macro('text_title', 'postcode', 'Postcode')
                @macro('text_title', 'country', 'Country', true)

            @endsection

        @endembed

        @embed('fragments.page.modal', ['id' => 'add-contact-modal', 'route' => ['suppliers.contact.store', $supplier->id], 'files' => true, 'title' => 'Add Contact', 'button' => trans('global.save')])

            @section('content')

                <div class="col-sm-6">
                    @macro('text_title', 'first_name', 'First name', true)
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'last_name', 'Last name', true)
                </div>

                <div class="col-sm-6">
                    @macro('select_title', 'type_id', $contact_types, 'Contact type', true)
                </div>
                <div class="col-sm-6">
                    @macro('image_title', 'media', 'Image')
                </div>

                <div class="col-sm-6">
                    @macro('text_title', 'telephone', 'Telephone')
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'mobile', 'Mobile')
                </div>
                <div class="col-sm-12">
                    @macro('text_title', 'email', 'Email address')
                </div>
                <div class="col-sm-12">
                    @macro('textarea_title', 'description', 'Description')
                </div>

            @endsection

        @endembed

@endsection
