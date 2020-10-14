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
                    <div class="btn-group pull-right">
                        <a href="{{ route('customer.tickets.create') }}" class="btn btn-default dropdown-toggle waves-effect waves-light">Submit Ticket <span class="m-l-5"><i class="fa fa-life-ring"></i></span></a>
                    </div>
                    <h3 class="portlet-title text-dark text-uppercase">Tickets</h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Project</th>
                                    <th class="hidden-xs">Severity</th>
                                    <th class="hidden-xs">Last updated</th>
                                    <th class="hidden-xs">Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach( $tickets as $ticket )
                                <tr>
                                    <td><a href="{{ route('customer.tickets.details', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                                    <td>
                                        @if( is_object($ticket->project) )
                                            {{ $ticket->project->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ FieldRenderer::severity($ticket->severity) }}</td>
                                    <td>{{ FieldRenderer::formatDate($ticket->updated_at) }}</td>
                                    <td>{{ ucwords($ticket->status) }}</td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

    </div>

@endsection
