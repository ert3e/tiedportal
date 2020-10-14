@extends('layout.email')

@section('content')

    <p>Your ticket has been received and a member of the team will be in touch shortly.</p>
    <p>Severity: <strong>{{ FieldRenderer::severity($ticket->severity) }}</strong></p>
    <p>{!! FieldRenderer::longtext($content) !!}</p>

    <p>View: <a href="{{ route('customer.tickets.view', $ticket->id) }}">{{ route('customer.tickets.view', $ticket->id) }}</a></p>

@endsection
