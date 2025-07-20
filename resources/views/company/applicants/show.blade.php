@extends('layouts.company')

@section('content')
    @include('partials._profile-content', ['user' => $user])
@endsection
