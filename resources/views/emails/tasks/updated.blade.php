@extends('layout.email')

@section('content')

    <p>A task you are assigned to has been updated by <strong>{!! FieldRenderer::user($updater) !!}</strong>.</p>
    <p><strong>{{ $task->title }}</strong></p>
    <p>{!! FieldRenderer::longtext($task->description) !!}</p>
    <p>Click here to view the task: {{ route('tasks.details', [$task->id]) }}</p>

@endsection