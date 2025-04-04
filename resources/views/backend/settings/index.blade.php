@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">General Settings</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Site Configuration</h6>
                <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target="#settingsHelp">
                    <i class="fas fa-question-circle"></i> Help
                </button>
            </div>

            <!-- Help Section -->
            <div class="collapse" id="settingsHelp">
                <div class="card-body bg-light">
                    <h5><i class="fas fa-info-circle text-primary"></i> Settings Guide</h5>
                    <p class="mb-1"><strong>Site Title:</strong> The name displayed in browser tabs and site header.</p>
                    <p class="mb-1"><strong>Site Logo:</strong> Recommended size: 250px × 80px (transparent PNG for best
                        results).</p>
                    <p class="mb-1"><strong>Maintenance Mode:</strong> When enabled, only administrators can access the
                        frontend.</p>
                    <p class="mb-0"><strong>Social Media:</strong> Include full URLs (e.g.,
                        https://facebook.com/yourpage).</p>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="mb-5">
                        <h5 class="text-primary mb-4"><i class="fas fa-info-circle"></i> Basic Information</h5>

                        <div class="form-group row">
                            <label for="site_title" class="col-md-3 col-form-label">Site Title *</label>
                            <div class="col-md-9">
                                <input id="site_title" type="text"
                                    class="form-control @error('site_title') is-invalid @enderror" name="site_title"
                                    value="{{ old('site_title', $settings['site_title'] ?? '') }}" required>
                                @error('site_title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="site_logo" class="col-md-3 col-form-label">Site Logo</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('site_logo') is-invalid @enderror"
                                        id="site_logo" name="site_logo"
                                        accept="image/png, image/jpeg, image/gif, image/svg+xml">
                                    <label class="custom-file-label" for="site_logo">Choose new logo...</label>
                                </div>

                                <!-- Logo Preview Area -->
                                <div class="logo-preview-container mt-3">
                                    @if (isset($settings['site_logo']) && $settings['site_logo'])
                                        <p class="mb-1">Current Logo:</p>
                                        <img src="{{ asset('images/' . $settings['site_logo']) }}" id="current-logo-preview"
                                            width="150" class="img-thumbnail d-block mb-2"
                                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}';">
                                    @else
                                        <p class="mb-1">Current Logo:</p>
                                        <div id="current-logo-preview" class="bg-light p-3 text-center mb-2"
                                            style="width:150px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="small mb-0">No logo set</p>
                                        </div>
                                    @endif

                                    <p class="mb-1">New Logo Preview:</p>
                                    <div id="new-logo-preview" class="bg-light p-3 text-center"
                                        style="width:150px; display:none;">
                                        <img id="logo-preview-image" src="#" alt="Logo preview"
                                            style="max-width:100%; display:none;">
                                        <i class="fas fa-image fa-3x text-muted preview-placeholder"></i>
                                        <p class="small mb-0 preview-text">Preview will appear here</p>
                                    </div>

                                </div>

                                @error('site_logo')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Recommended dimensions: 250px × 80px (transparent PNG
                                    preferred)</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_email" class="col-md-3 col-form-label">Contact Email *</label>
                            <div class="col-md-9">
                                <input id="contact_email" type="email"
                                    class="form-control @error('contact_email') is-invalid @enderror" name="contact_email"
                                    value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" required>
                                @error('contact_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="mb-5">
                        <h5 class="text-primary mb-4"><i class="fas fa-share-alt"></i> Social Media Links</h5>

                        <div class="form-group row">
                            <label for="facebook_url" class="col-md-3 col-form-label">Facebook</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                    </div>
                                    <input id="facebook_url" type="url"
                                        class="form-control @error('facebook_url') is-invalid @enderror"
                                        name="facebook_url"
                                        value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                                        placeholder="https://facebook.com/yourpage">
                                </div>
                                @error('facebook_url')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="twitter_url" class="col-md-3 col-form-label">Twitter</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                    </div>
                                    <input id="twitter_url" type="url"
                                        class="form-control @error('twitter_url') is-invalid @enderror" name="twitter_url"
                                        value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"
                                        placeholder="https://twitter.com/yourhandle">
                                </div>
                                @error('twitter_url')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instagram_url" class="col-md-3 col-form-label">Instagram</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                    </div>
                                    <input id="instagram_url" type="url"
                                        class="form-control @error('instagram_url') is-invalid @enderror"
                                        name="instagram_url"
                                        value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                                        placeholder="https://instagram.com/yourprofile">
                                </div>
                                @error('instagram_url')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="linkedin_url" class="col-md-3 col-form-label">LinkedIn</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-linkedin-in"></i></span>
                                    </div>
                                    <input id="linkedin_url" type="url"
                                        class="form-control @error('linkedin_url') is-invalid @enderror"
                                        name="linkedin_url"
                                        value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                                        placeholder="https://linkedin.com/company/yourcompany">
                                </div>
                                @error('linkedin_url')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="youtube_url" class="col-md-3 col-form-label">YouTube</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                    </div>
                                    <input id="youtube_url" type="url"
                                        class="form-control @error('youtube_url') is-invalid @enderror" name="youtube_url"
                                        value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                                        placeholder="https://youtube.com/yourchannel">
                                </div>
                                @error('youtube_url')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- System Settings Section -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-4"><i class="fas fa-cog"></i> System Settings</h5>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Site Status</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="maintenance_mode"
                                        name="maintenance_mode" value="1"
                                        {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="maintenance_mode">Maintenance Mode</label>
                                </div>
                                <small class="form-text text-muted">When enabled, only administrators can access the
                                    frontend.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Features</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="enable_registration"
                                        name="enable_registration" value="1"
                                        {{ old('enable_registration', $settings['enable_registration'] ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="enable_registration">User
                                        Registration</label>
                                    <small class="form-text text-muted d-block">Allow new users to register
                                        accounts.</small>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enable_comments"
                                        name="enable_comments" value="1"
                                        {{ old('enable_comments', $settings['enable_comments'] ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="enable_comments">Comments System</label>
                                    <small class="form-text text-muted d-block">Enable commenting on posts and
                                        articles.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-group row mb-0">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-2"></i> Save Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary ml-2">
                                <i class="fas fa-undo mr-2"></i> Reset Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // File input label update
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("site_logo").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Show preview of new logo
            readURL(this);
        });

        // Toggle help section
        $('#settingsHelp').on('show.bs.collapse', function() {
            $('[data-target="#settingsHelp"]').html('<i class="fas fa-times"></i> Close Help');
        }).on('hide.bs.collapse', function() {
            $('[data-target="#settingsHelp"]').html('<i class="fas fa-question-circle"></i> Help');
        });

        // Logo preview functionality
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Hide placeholder and show preview image
                    $('#new-logo-preview').show();
                    $('#logo-preview-image').attr('src', e.target.result).show();
                    $('.preview-placeholder').hide();
                    $('.preview-text').hide();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Reset form handling
        $('button[type="reset"]').click(function() {
            $('#new-logo-preview').hide();
            $('#logo-preview-image').hide().attr('src', '#');
            $('.preview-placeholder').show();
            $('.preview-text').show();
            $('#remove_logo').prop('checked', false);
            $('#current-logo-preview').show();
        });
    </script>
@endpush
