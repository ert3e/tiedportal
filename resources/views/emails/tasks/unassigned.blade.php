@extends('layout.email')

@section('content')

    <p>You have been removed from the task <strong>{{ $task->title }}</strong> by <strong>{!! FieldRenderer::user($assigner) !!}</strong>.</p>

@endsection