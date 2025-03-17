<!-- resources/views/auth/register.blade.php -->
@extends('layouts.auth')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">{{ __('Create an Account!') }}</h1>
    </div>
    <form class="user" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user" id="password-confirm" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat Password">
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            {{ __('Register') }}
        </button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{ route('login') }}">{{ __('Already have an account? Login!') }}</a>
    </div>
@endsection