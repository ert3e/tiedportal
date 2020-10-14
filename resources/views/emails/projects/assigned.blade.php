@extends('layout.email')

@section('content')

    <p>A project has been assigned to you by <strong>{!! FieldRenderer::user($assigner) !!}</strong>.</p>
    <p><strong>{{ $project->name }}</strong></p>
    <p>{!! FieldRenderer::longtext($project->description) !!}</p>
    <p>Click here to view the project: {{ route('projects.details', [$project->id]) }}</p>

@endsection