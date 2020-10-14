@extends('layout.email')

@section('content')

    <p>Welcome to the Blush.Manager system.</p>
    @if( $content )
        <p>{{ $content }}</p>
    @endif
    <p>Your username is {{ $user->username }}.</p>
    <p>Click here to reset your password: {{ route('password.reset', [$token]) }}</p>

@endsection