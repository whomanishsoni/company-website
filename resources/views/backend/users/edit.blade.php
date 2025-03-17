@extends('layouts.backend')

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
    </div>

    <!-- Note for Required Fields -->
    <p class="text-muted">Fields marked with <span class="text-danger">*</span> are required.</p>

    <form action="{{ route('users.update', $user->id) }}" method="POST" id="edit-user-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label> <!-- Added asterisk -->
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label> <!-- Added asterisk -->
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">New Password (leave blank to keep current password)</label>
            <input type="password" name="password" id="password" class="form-control" minlength="8">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" minlength="8">
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#edit-user-form').on('submit', function (e) {
            if ($('#password').val() !== $('#password_confirmation').val()) {
                e.preventDefault();
                alert('Passwords do not match.');
            }
        });
    });
</script>
@endpush