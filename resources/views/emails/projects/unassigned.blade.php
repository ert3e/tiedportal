@extends('layout.email')

@section('content')

    <p>You have been removed from the project <strong>{{ $project->name }}</strong> by <strong>{!! FieldRenderer::user($assigner) !!}</strong>.</p>

@endsection