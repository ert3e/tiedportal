@extends('layout.email')

@section('content')

    <p>{!! TimelineRenderer::user($event) !!} {!! EventRenderer::title($event) !!}</p>
    @if( EventRenderer::description($event) )
        <p>{!! EventRenderer::description($event) !!}</p>
    @endif
    @if( TimelineRenderer::url($event) )
        <p>View: <a href="{{ TimelineRenderer::url($event) }}">{{ TimelineRenderer::url($event) }}</a></p>
    @endif

@endsection