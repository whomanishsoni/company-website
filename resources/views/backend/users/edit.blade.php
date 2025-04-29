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

        <form action="{{ route('users.update', $user->id) }}" method="POST" id="edit-user-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row d-flex align-items-stretch">
                <!-- Left Column - Profile Picture Card -->
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card shadow w-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <!-- Image Preview -->
                            <div class="mb-3 text-center flex-grow-1 d-flex flex-column justify-content-center">
                                <img id="photo-preview"
                                    src="{{ $user->photo ? asset('storage/users/' . $user->photo) : asset('images/default-user.png') }}"
                                    alt="Profile Preview" class="img-thumbnail rounded-circle mx-auto"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                            <!-- Upload Button -->
                            <div class="form-group mt-auto">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo"
                                        accept="image/jpeg, image/png">
                                    <label class="custom-file-label" for="photo">Choose file</label>
                                </div>
                                @error('photo')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Recommended size: 200x200px (1:1 ratio), Max 2MB
                                </small>
                                <div class="mt-2">
                                    <button type="button" id="clear-photo"
                                        class="btn btn-outline-danger {{ $user->photo ? '' : 'd-none' }} w-100">
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - User Details -->
                <div class="col-md-8 mb-4 d-flex">
                    <div class="card shadow w-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" required
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">New Password (leave blank to keep current password)</label>
                                <input type="password" name="password" id="password" class="form-control" minlength="8">
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" minlength="8">
                                @error('password_confirmation')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer mt-auto">
                            <button type="submit" class="btn btn-primary">
                                Update User
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Password confirmation validation
            $('#edit-user-form').on('submit', function(e) {
                if ($('#password').val() !== $('#password_confirmation').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Mismatch',
                        text: 'The password and confirmation password do not match.',
                    });
                }
            });

            // Show selected file name in file input and preview image
            $('#photo').on('change', function() {
                const file = this.files[0];
                const preview = $('#photo-preview');
                const clearBtn = $('#clear-photo');

                // Update file label
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);

                // Preview the image
                if (file) {
                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'Please upload only JPG or PNG images.',
                        });
                        $(this).val('');
                        $(this).next('.custom-file-label').removeClass("selected").html('Choose file');
                        clearBtn.addClass('d-none');
                        return;
                    }

                    if (file.size > 2048 * 1024) { // 2MB limit
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'Please select an image smaller than 2MB.',
                        });
                        $(this).val('');
                        $(this).next('.custom-file-label').removeClass("selected").html('Choose file');
                        clearBtn.addClass('d-none');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                        clearBtn.removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.attr('src',
                        "{{ $user->photo ? asset('storage/users/' . $user->photo) : asset('images/default-user.png') }}"
                    );
                    if (!"{{ $user->photo }}") {
                        clearBtn.addClass('d-none');
                    }
                }
            });


            // Clear photo selection
            $('#clear-photo').on('click', function() {
                $('#photo').val('');
                $('#photo').next('.custom-file-label').removeClass("selected").html('Choose file');
                $('#photo-preview').attr('src', "{{ asset('images/default-user.png') }}");
                $(this).addClass('d-none');

                // Add a hidden input to indicate photo should be removed
                $('#edit-user-form').append('<input type="hidden" name="remove_photo" value="1">');
            });
        });
    </script>
@endpush
