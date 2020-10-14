@extends('layout.email')

@section('content')

    <p>The task <strong>{{ $task->title }}</strong> has been closed by <strong>{!! FieldRenderer::user($assigner) !!}</strong>.</p>
    <p>Click here to view the task: {{ route('tasks.details', [$task->id]) }}</p>

@endsection