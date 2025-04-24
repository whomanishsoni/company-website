@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mail Settings</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mail Settings</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('mail-settings.update') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="mailer">Mail Driver</label>
                        <select name="mailer" id="mailer" class="form-control @error('mailer') is-invalid @enderror">
                            <option value="smtp" {{ old('mailer', $settings->mailer) == 'smtp' ? 'selected' : '' }}>SMTP
                            </option>
                            <option value="sendmail" {{ old('mailer', $settings->mailer) == 'sendmail' ? 'selected' : '' }}>
                                Sendmail</option>
                            <option value="mailgun" {{ old('mailer', $settings->mailer) == 'mailgun' ? 'selected' : '' }}>
                                Mailgun</option>
                            <option value="ses" {{ old('mailer', $settings->mailer) == 'ses' ? 'selected' : '' }}>SES
                            </option>
                            <option value="postmark" {{ old('mailer', $settings->mailer) == 'postmark' ? 'selected' : '' }}>
                                Postmark</option>
                            <option value="log" {{ old('mailer', $settings->mailer) == 'log' ? 'selected' : '' }}>Log
                            </option>
                        </select>
                        @error('mailer')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="host">SMTP Host</label>
                        <input type="text" name="host" id="host"
                            class="form-control @error('host') is-invalid @enderror"
                            value="{{ old('host', $settings->host) }}">
                        @error('host')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="port">SMTP Port</label>
                        <input type="number" name="port" id="port"
                            class="form-control @error('port') is-invalid @enderror"
                            value="{{ old('port', $settings->port) }}">
                        @error('port')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $settings->username) }}">
                        @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password', $settings->password) }}">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="encryption">Encryption</label>
                        <select name="encryption" id="encryption"
                            class="form-control @error('encryption') is-invalid @enderror">
                            <option value="null"
                                {{ old('encryption', $settings->encryption) == 'null' ? 'selected' : '' }}>None</option>
                            <option value="ssl"
                                {{ old('encryption', $settings->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="tls"
                                {{ old('encryption', $settings->encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                        </select>
                        @error('encryption')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="from_address">From Address</label>
                        <input type="email" name="from_address" id="from_address"
                            class="form-control @error('from_address') is-invalid @enderror"
                            value="{{ old('from_address', $settings->from_address) }}">
                        @error('from_address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="from_name">From Name</label>
                        <input type="text" name="from_name" id="from_name"
                            class="form-control @error('from_name') is-invalid @enderror"
                            value="{{ old('from_name', $settings->from_name) }}">
                        @error('from_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
@endsection
