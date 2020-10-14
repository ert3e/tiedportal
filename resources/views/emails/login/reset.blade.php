@extends('layout.email')

@section('content')

    <p>Your username is {{ $user->username }}.</p>
    <p>Click here to reset your password: {{ route('password.reset', [$token]) }}</p>

@endsection