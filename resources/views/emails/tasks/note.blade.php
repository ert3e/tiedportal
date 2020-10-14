@extends('layout.email')

@section('content')

    <p><strong>{!! FieldRenderer::user($sender) !!}</strong> has commented on the task <strong>{{ $task->title }}</strong>.</p>
    <p>{!! FieldRenderer::longtext($note->content) !!}</p>
    <p>Click here to view the task: {{ route('tasks.details', [$task->id]) }}</p>

@endsection