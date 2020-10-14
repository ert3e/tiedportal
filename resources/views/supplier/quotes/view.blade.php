@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('customers', 'edit') || Permissions::has('contacts', 'create') || Permissions::has('customers', 'delete') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                @if( Permissions::has('customers', 'edit') )
                    <li>
                        <a href="#add-address-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Address</a>
                    </li>
                @endif
                @if( Permissions::has('contacts', 'create') )
                    <li>
                        <a href="#add-contact-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Contact</a>
                    </li>
                @endif
                @if( Permissions::has('customers', 'delete') )
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Customer" data-message="Are you sure you want to delete this customer? This action cannot be undone!" data-confirm="Customer deleted!" data-redirect="{{ route('customers.index') }}" data-href="{{ route('customers.delete', ['id' => $customer->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Customer</a>
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
        <div class="row">

            <div class="col-lg-3 col-lg-push-9">
                @if( $quote_request->status == 'pending' )
                    <div class="card-box">
                        <h4 class="m-t-0 m-b-30 header-title"><b>Quote Tools</b></h4>
                        <div class="row">
                            <div class="btn-group btn-group-block" role="group">
                                <a href="#submit-quote-modal" class="btn btn-lg btn-success col-sm-6" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-thumbs-up"></i> Quote</a>
                                <a href="#decline-quote-modal" class="btn btn-lg btn-danger col-sm-6" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-thumbs-down"></i> Decline</a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Dates</b></h4>
                    <div class="col-lg-6">
                        @macro('label_title', 'Start Date', FieldRenderer::formatDate($project->start_date))
                    </div>
                    <div class="col-lg-6">
                        @macro('label_title', 'Due Date', FieldRenderer::formatDate($project->due_date))
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-lg-9 col-lg-pull-3">

                @if( strlen($quote_request->message) )
                    <div class="card-box">
                        <h4 class="m-t-0 m-b-30 header-title"><b>Quote Request</b></h4>
                        <div class="col-lg-6">
                            @macro('label_title', 'Message', $quote_request->message)
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @endif

                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Project</b></h4>
                    <div class="col-lg-6">
                        @macro('label_title', 'Name', $project->name)
                    </div>
                    <div class="col-lg-6">
                        @macro('label_title', 'Type(s)', $project_types)
                    </div>
                    <div class="col-lg-12">
                        @macro('label_title', 'Description', $project->description)
                    </div>
                    <div class="clearfix"></div>
                </div>

                @if( $quote_request->components->count() )

                    <div class="card-box">
                        <h4 class="m-t-0 m-b-30 header-title"><b>Components</b></h4>
                        @foreach( $quote_request->components as $component )
                            @include('fragments.page.component', ['component' => $component])
                        @endforeach
                        <div class="clearfix"></div>
                    </div>

                @endif

                @if( $quote_request->quotes->count() )

                    <div class="card-box">
                        <h4 class="m-t-0 m-b-30 header-title"><b>Quotes</b></h4>
                        @foreach( $quote_request->quotes as $quote )
                            @include('fragments.page.quote', ['quote' => $quote])
                        @endforeach

                        <a href="#submit-quote-modal" class="btn btn-sm btn-primary pull-right" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-cloud-upload"></i> Submit another quote</a>
                        <div class="clearfix"></div>
                    </div>

                @endif

                    @include('fragments.notes.notes', ['route' => ['supplier.quotes.notes.add', $quote_request->id]])
            </div>

        </div>
    </div>

    @embed('fragments.page.modal', ['id' => 'submit-quote-modal', 'route' => ['supplier.quotes.submit', $quote_request->id], 'files' => true, 'title' => 'Submit quote', 'button' => trans('global.save')])

        @section('content')
            {!! Form::hidden('status', 'submitted') !!}
            <p>Please enter any message you would like to include with the quote and upload a quote document if available. <strong>Additional quotes can be supplied after completing this form.</strong></p>
            @macro('text_title', 'reference', 'Reference (if applicable)')
            @macro('file_title', 'media', 'File')
            <div class="row">
                <div class="col-md-8">
                    @macro('decimal_title', 'cost', 'Cost')
                </div>
                <div class="col-md-3">
                    @macro('checkbox_title', 'includes_vat', 'Includes VAT')
                </div>
            </div>
            @macro('textarea_title', 'message', 'Message')
        @endsection

    @endembed

     @embed('fragments.page.modal', ['id' => 'decline-quote-modal', 'route' => ['supplier.quotes.submit', $quote_request->id], 'files' => false, 'title' => 'Decline project', 'button' => trans('global.save')])

        @section('content')
            {!! Form::hidden('status', 'declined') !!}
            <p>Please let us know why you would like to decline this project to help us improve our service. <strong>Once declined this project will not be available to quote.</strong></p>
            @macro('textarea_title', 'message', 'Message')
        @endsection

    @endembed

@endsection
