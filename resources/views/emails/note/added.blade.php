@extends('layout.email')

@section('content')

    <p>{!! FieldRenderer::user($sender) !!} added a note to the {{ $object->object_type }} <strong>{{ $object->displayName() }}</strong>.</p>
    <p>{!! FieldRenderer::longtext($note->content) !!}</p>
    @if( FieldRenderer::url($object) )
        <p>View: <a href="{{ FieldRenderer::url($object) }}">{{ FieldRenderer::url($object) }}</a></p>
    @endif

@endsection
