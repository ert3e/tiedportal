@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-3 col-lg-push-9">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">Status</h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="col-md-6">
                            @macro('text_display', 'Severity', FieldRenderer::severity($ticket->severity))
                        </div>
                        <div class="col-md-6">
                            @macro('text_display', 'Status', ucwords($ticket->status))
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-lg-pull-3">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">Ticket #{{ $ticket->id }} {{ $ticket->subject }}</h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <p>Ticket submitted by {!! FieldRenderer::user($ticket->user) !!} on {{ FieldRenderer::formatDate($ticket->created_at) }} at {{ FieldRenderer::formatTime($ticket->created_at) }}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <p>{!! FieldRenderer::longtext($ticket->content) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">Conversation</h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">

                        <div class="card-box note-container">

                            {!! Form::open(['route' => ['tickets.notes.add', $ticket->id]]) !!}
                            <h4 class="m-t-0 m-b-30 header-title"><b>Comments</b></h4>
                            {!! Form::textarea('note', null, ['class' => 'form-control note expand', 'placeholder' => 'Add a comment...']) !!}
                            <div class="buttons">
                                <button type="submit" class="btn margin-top btn-primary pull-right add-note hidden" data-loading-text="Adding comment..."><i class="fa fa-send"></i> Add Comment</button>
                            </div>
                            <div style="clear: both"></div>
                            <hr>
                            <div class="p-20 p-t-0">
                                <div class="notes timeline-2 margin-top">
                                    @foreach( $notes as $note )
                                        @include('fragments.notes.note', ['note' => $note])
                                    @endforeach
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div> <!-- end col -->

    </div>

@endsection
