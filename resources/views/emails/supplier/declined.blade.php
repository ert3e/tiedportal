@extends('layout.email')

@section('content')

    <p><strong>{{ $supplier->name }}</strong> has declined to quote the project <strong>{{ $project->name }}</strong>.</p>
    @if( strlen($reason) )
        <p>They gave the following reason:<br/><br/>{{ $reason }}</p>
    @endif
    <p>Click here to view the project: {{ route('projects.details', [$project->id]) }}</p>

@endsection