@extends('layout.email')

@section('content')

    <p>{!! FieldRenderer::user($ticket->user) !!} submitted a ticket
    @if( is_object($ticket->project) )
        to the project <strong>{{ $ticket->project->name }}</strong>
    @endif
    </p>
    <p>Severity: <strong>{{ FieldRenderer::severity($ticket->severity) }}</strong></p>
    <p>{!! FieldRenderer::longtext($content) !!}</p>

    <p>View: <a href="{{ route('tickets.view', $ticket->id) }}">{{ route('tickets.view', $ticket->id) }}</a></p>

@endsection
