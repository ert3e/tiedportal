@extends('layout.email')

@section('content')

    <p>Welcome to the Blush.Manager supplier system.</p>
    <p>Your username is {{ $user->username }}.</p>
    <p>Click here to reset your password: {{ route('password.reset', [$token]) }}</p>

@endsection