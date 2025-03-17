<!-- resources/views/auth/verify.blade.php -->
@extends('layouts.auth')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">{{ __('Verify Your Email Address') }}</h1>
    </div>
    <div class="text-center">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
    <hr>
    <div class="text-center">
        <a class="small" href="{{ route('login') }}">{{ __('Back to Login') }}</a>
    </div>
@endsection