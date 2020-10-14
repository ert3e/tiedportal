@extends('layout.email')

@section('content')

    <p>A project you are assigned to has been updated by <strong>{!! FieldRenderer::user($updater) !!}</strong>.</p>
    <p><strong>{{ $project->name }}</strong></p>
    <p>{!! FieldRenderer::longtext($project->description) !!}</p>
    <p>Click here to view the project: {{ route('projects.details', [$project->id]) }}</p>

@endsection