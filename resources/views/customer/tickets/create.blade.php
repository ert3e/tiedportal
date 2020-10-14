@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">Submit Ticket</h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        {!! Form::open(['route' => 'customer.tickets.store']) !!}
                            <p>Please complete the form below to submit a ticket. Please include as much detail as possible and where applicable include any login details that may be useful in resolving the issue.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    @macro('select_title', 'project_id', $projects, 'Project', false)
                                </div>
                                <div class="col-md-6">
                                    @macro('select_title', 'severity', $severities, 'Severity', false, 1)
                                </div>
                            </div>
                            @macro('text_title', 'subject', 'Subject', true)
                            @macro('textarea_title', 'description', 'Description', true)
                            <button type="submit" class="btn btn-default dropdown-toggle waves-effect waves-light"><i class="fa fa-send"></i> Submit Ticket</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

    </div>

@endsection
