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
                            <label for="favicon" class="col-md-3 col-form-label">Favicon</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('favicon') is-invalid @enderror"
                                        id="favicon" name="favicon" accept=".ico,image/x-icon,image/png">
                                    <label class="custom-file-label" for="favicon">Choose new favicon...</label>
                                </div>

                                <!-- Updated Favicon Preview Area -->
                                <div class="favicon-preview-container mt-3">
                                    @if (isset($settings['favicon']) && $settings['favicon'])
                                        <p class="mb-1">Current Favicon:</p>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('favicons/' . $settings['favicon']) }}"
                                                id="current-favicon-preview" width="32" height="32"
                                                class="img-thumbnail d-block mr-2">
                                        </div>
                                    @else
                                        <p class="mb-1">Current Favicon:</p>
                                        <div class="d-flex align-items-center">
                                            <div id="current-favicon-preview" class="bg-light p-2 text-center mr-2"
                                                style="width:32px; height:32px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            <span class="text-muted">No favicon set</span>
                                        </div>
                                    @endif

                                    <p class="mb-1 mt-3">New Favicon Preview:</p>
                                    <div id="new-favicon-preview" class="bg-light p-2 text-center mb-2"
                                        style="width:32px; height:32px; display:none;">
                                        <img id="favicon-preview-image" src="#" alt="Favicon preview"
                                            style="max-width:100%; max-height:100%; display:none;">
                                        <i class="fas fa-image text-muted preview-placeholder"></i>
                                    </div>
                                </div>

                                @error('favicon')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Recommended format: .ico or .png (16×16 or 32×32
                                    pixels)</small>
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

                    <!-- Cookie Consent Section -->
                    <div class="mb-5">
                        <h5 class="text-primary mb-4"><i class="fas fa-cookie-bite"></i> Cookie Consent</h5>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Cookie Consent</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enable_cookie_consent"
                                        name="enable_cookie_consent" value="1"
                                        {{ old('enable_cookie_consent', $settings['enable_cookie_consent'] ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="enable_cookie_consent">Enable Cookie Consent
                                        Banner</label>
                                </div>
                                <small class="form-text text-muted">Display a cookie consent banner to comply with privacy
                                    regulations.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cookie_message" class="col-md-3 col-form-label">Cookie Message</label>
                            <div class="col-md-9">
                                <textarea id="cookie_message" class="form-control @error('cookie_message') is-invalid @enderror"
                                    name="cookie_message" rows="3">{{ old('cookie_message', $settings['cookie_message'] ?? 'We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.') }}</textarea>
                                @error('cookie_message')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Customize the message shown in the cookie consent
                                    banner.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="privacy_policy_url" class="col-md-3 col-form-label">Privacy Policy URL</label>
                            <div class="col-md-9">
                                <input id="privacy_policy_url" type="url"
                                    class="form-control @error('privacy_policy_url') is-invalid @enderror"
                                    name="privacy_policy_url"
                                    value="{{ old('privacy_policy_url', $settings['privacy_policy_url'] ?? '') }}"
                                    placeholder="https://yoursite.com/privacy-policy">
                                @error('privacy_policy_url')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Link to your privacy policy page (used in cookie
                                    banner).</small>
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

                    <!-- Cache Management Section -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-4"><i class="fas fa-broom"></i> Cache Management</h5>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Clear Cache</label>
                            <div class="col-md-9">
                                <button type="button" class="btn btn-outline-danger" id="clear-cache">
                                    Clear Cache
                                </button>
                                <small class="form-text text-muted">Clears all cached settings and views. This happens
                                    automatically when saving settings.</small>
                            </div>
                        </div>
                    </div>


                    <!-- Form Actions -->
                    <div class="form-group row mb-0">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary px-4">
                                Save Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary ml-2">
                                Reset Changes
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
        // File input label update for both logo and favicon
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                var fileName = this.files[0]?.name || 'Choose file...';
                var nextSibling = e.target.nextElementSibling;
                nextSibling.innerText = fileName;

                // Show preview of new file
                if (this.id === 'site_logo') {
                    previewFile(this, {
                        previewId: '#logo-preview-image',
                        containerId: '#new-logo-preview',
                        placeholder: '#new-logo-preview .preview-placeholder',
                        text: '#new-logo-preview .preview-text'
                    });
                } else if (this.id === 'favicon') {
                    previewFile(this, {
                        previewId: '#favicon-preview-image',
                        containerId: '#new-favicon-preview',
                        placeholder: '#new-favicon-preview .preview-placeholder'
                    });
                }
            });
        });

        // Toggle help section
        $('#settingsHelp').on('show.bs.collapse', function() {
            $('[data-target="#settingsHelp"]').html('<i class="fas fa-times"></i> Close Help');
        }).on('hide.bs.collapse', function() {
            $('[data-target="#settingsHelp"]').html('<i class="fas fa-question-circle"></i> Help');
        });

        // Enhanced file preview functionality
        function previewFile(input, options) {
            if (input.files && input.files[0]) {
                // Check file size and type
                const file = input.files[0];
                const maxSize = input.id === 'favicon' ? 1024 * 1024 : 2 * 1024 * 1024; // 1MB for favicon, 2MB for logo
                const validTypes = input.id === 'favicon' ? ['image/x-icon', 'image/vnd.microsoft.icon', 'image/png'] : [
                    'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'
                ];

                if (file.size > maxSize) {
                    alert(`File is too large. Maximum size is ${maxSize/1024}KB`);
                    resetFileInput(input);
                    return;
                }

                if (!validTypes.includes(file.type)) {
                    alert(
                        `Invalid file type. Please upload a ${input.id === 'favicon' ? '.ico or .png' : 'JPEG, PNG, GIF or SVG'} file`
                    );
                    resetFileInput(input);
                    return;
                }

                // Proceed with preview if validation passes
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Show container and preview image
                    $(options.containerId).show();
                    $(options.previewId)
                        .attr('src', e.target.result)
                        .on('load', function() {
                            $(this).show();
                            if (options.placeholder) $(options.placeholder).hide();
                            if (options.text) $(options.text).hide();
                        })
                        .on('error', function() {
                            alert('Error loading image preview');
                            resetFileInput(input);
                        });
                }

                reader.onerror = function() {
                    alert('Error reading file');
                    resetFileInput(input);
                };

                reader.readAsDataURL(file);
            }
        }

        // Reset file input and preview
        function resetFileInput(input) {
            $(input).val('').next('.custom-file-label').text('Choose file...');
            const containerId = input.id === 'site_logo' ? '#new-logo-preview' : '#new-favicon-preview';
            $(containerId).hide();
            $(containerId + ' img').attr('src', '#').hide();
            $(containerId + ' .preview-placeholder').show();
            if (containerId === '#new-logo-preview') {
                $(containerId + ' .preview-text').show();
            }
        }

        // Clear cache button
        $('#clear-cache').click(function() {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Clearing...');

            $.ajax({
                url: "{{ route('settings.clear-cache') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    btn.html('<i class="fas fa-check-circle mr-2"></i> Cache Cleared').removeClass(
                        'btn-outline-danger').addClass('btn-success');
                    setTimeout(function() {
                        btn.html('Clear Cache')
                            .removeClass('btn-success').addClass('btn-outline-danger').prop(
                                'disabled', false);
                    }, 2000);
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'Error clearing cache';
                    btn.html(`<i class="fas fa-exclamation-circle mr-2"></i> ${errorMsg}`).removeClass(
                        'btn-outline-danger').addClass('btn-danger');
                    setTimeout(function() {
                        btn.html('Clear Cache')
                            .removeClass('btn-danger').addClass('btn-outline-danger').prop(
                                'disabled', false);
                    }, 3000);
                }
            });
        });

        // Reset form handling
        $('button[type="reset"]').click(function() {
            // Hide all new previews and reset file inputs
            $('[id^="new-"]').hide();
            $('[id$="-preview-image"]').attr('src', '#').hide();
            $('.custom-file-input').each(function() {
                $(this).val('').next('.custom-file-label').text('Choose file...');
            });

            // Show placeholders
            $('.preview-placeholder').show();
            $('.preview-text').show();

            // Uncheck all remove checkboxes
            $('[id^="remove_"]').prop('checked', false);

            // Show all current previews
            $('[id^="current-"]').show();
        });

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
