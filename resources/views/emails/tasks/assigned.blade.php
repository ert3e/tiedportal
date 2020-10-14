@extends('layout.email')

@section('content')

    <p>A task has been assigned to you by <strong>{!! FieldRenderer::user($assigner) !!}</strong>.</p>
    <p><strong>{{ $task->title }}</strong></p>
    <p>{!! FieldRenderer::longtext($task->description) !!}</p>
    <p>Click here to view the task: {{ route('tasks.details', [$task->id]) }}</p>

@endsection