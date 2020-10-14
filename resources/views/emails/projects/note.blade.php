@extends('layout.email')

@section('content')

    <p><strong>{!! FieldRenderer::user($sender) !!}</strong> has commented on the project <strong>{{ $project->name }}</strong>.</p>
    <p>{!! FieldRenderer::longtext($note->content) !!}</p>
    <p>Click here to view the project: {{ route('projects.details', [$project->id]) }}</p>

@endsection