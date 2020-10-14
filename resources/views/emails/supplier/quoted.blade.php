@extends('layout.email')

@section('content')

    <p><strong>{{ $supplier->name }}</strong> has submitted a quote for the project <strong>{{ $project->name }}</strong>.</p>
    <p>Cost: <strong>{{ FieldRenderer::formatCurrency($quote->cost) }} {{{ $quote->includes_vat ? ' (inc VAT)' : '(ex VAT)' }}}</strong></p>
    @if( strlen($quote->reference) )
        <p>Reference: <strong>{{ $quote->reference }}</strong></p>
    @endif
    @if( strlen($quote->message) )
        <p >Message: <strong>{{ $quote->message }}</strong></p>
    @endif
    @foreach( $quote->media as $media )
        <p><a href="{{ route('media.download', $media->id, str_slug($media->name)) }}" title="{{ $media->name }}" target="_blank">Download {{ $media->name }}</a></p>
    @endforeach
    @if( strlen($quote->message) )
        <p>They added the following message:<br/><br/>{{ $quote->message }}</p>
    @endif

    <p>Click here to view the project: {{ route('projects.details', [$project->id]) }}</p>

@endsection