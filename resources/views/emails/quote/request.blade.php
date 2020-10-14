@extends('layout.email')

@section('content')

    <p>Hi {{ $contact->first_name }},</p>

    <p>A project is available to quote.</p>
    @if( strlen($text) )
        <p>{{ $text }}</p>
    @endif

    <p>Click here to submit your quote {{ route('supplier.quotes.view', $quote_request->id) }}</p>

@endsection