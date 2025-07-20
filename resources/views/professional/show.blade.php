@extends('layouts.nextwork')

@section('title', 'Professional Profile - {{ $user->name }}')

@section('content')

    @include('partials._profile-content', [
        'user' => $user,
        'connectionStatus' => $connectionStatus,
        'connection' => $connection,
    ])
@endsection
