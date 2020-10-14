@extends('layout.email')

@section('content')

    <p>{!! FieldRenderer::user($assigner) !!} assigned you to the {{ $object->object_type }} <strong>{{ $object->displayName() }}</strong>.</p>
    @if( FieldRenderer::url($object) )
        <p>View: <a href="{{ FieldRenderer::url($object) }}">{{ FieldRenderer::url($object) }}</a></p>
    @endif

@endsection
