@extends('layouts.backend')

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('members.index') }}">Members</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Member</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Member</h1>
    </div>

    <!-- Note for Required Fields -->
    <p class="text-muted">Fields marked with <span class="text-danger">*</span> are required.</p>

    <form action="{{ route('members.store') }}" method="POST" id="create-member-form">
        @csrf
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="father_name">Father's Name <span class="text-danger">*</span></label>
            <input type="text" name="father_name" id="father_name" class="form-control" required>
            @error('father_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" name="dob" id="dob" class="form-control" required>
            @error('dob')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="whatsapp">WhatsApp Number <span class="text-danger">*</span></label>
            <input type="text" name="whatsapp" id="whatsapp" class="form-control" required>
            @error('whatsapp')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="alt_no">Alternate Number</label>
            <input type="text" name="alt_no" id="alt_no" class="form-control">
            @error('alt_no')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Address <span class="text-danger">*</span></label>
            <textarea name="address" id="address" class="form-control" required></textarea>
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="city">City <span class="text-danger">*</span></label>
            <input type="text" name="city" id="city" class="form-control" required>
            @error('city')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="state_id">State <span class="text-danger">*</span></label>
            <select name="state_id" id="state_id" class="form-control" required>
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
            @error('state_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="pincode">Pincode <span class="text-danger">*</span></label>
            <input type="text" name="pincode" id="pincode" class="form-control" required>
            @error('pincode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="business">Business</label>
            <select name="business" id="business" class="form-control">
                <option value="">Select Business</option>
                <option value="IT">IT</option>
                <option value="Retail">Retail</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Education">Education</option>
                <option value="Other">Other</option>
            </select>
            @error('business')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="blood_group">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-control">
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
            @error('blood_group')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="inspirer">Inspirer</label>
            <input type="text" name="inspirer" id="inspirer" class="form-control">
            @error('inspirer')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="cooperation_field">Cooperation Field</label>
            <input type="text" name="cooperation_field" id="cooperation_field" class="form-control">
            @error('cooperation_field')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
@endsection
