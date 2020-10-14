@extends('layout.email')

@section('content')

    <p>Welcome {{ $user->first_name }} {{ $user->last_name }},</p>

    <p>Your new account is setup and you username is <strong>{{ $user->username }}</strong>.</p>
    <p>Your password to access the system is <strong>{{ $password }}</strong>. We recommend you change this as soon as possible.</p>

    <p>Click here to reset your password: {{ route('users.profile') }}</p>

@endsection