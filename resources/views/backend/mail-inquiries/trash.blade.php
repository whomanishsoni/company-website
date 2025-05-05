@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        <!-- AJAX Alert Container -->
        <div id="ajax-alert-container"></div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mail-inquiries.index') }}">Mail Inquiries</a></li>
                <li class="breadcrumb-item active" aria-current="page">Trash</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Trash</h1>
            <div>
                <button type="button" id="restore-selected" class="btn btn-success mr-2">
                    <span id="restore-button-text">Restore Selected (0)</span>
                </button>
                <button type="button" id="delete-selected" class="btn btn-danger">
                    <span id="delete-button-text">Delete Permanently (0)</span>
                </button>
            </div>
        </div>

        <!-- Trashed Inquiries Table -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mail-inquiries-table" class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="20">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Global functions
        function showAlert(type, message) {
            $('#ajax-alert-container').html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `);
            setTimeout(() => $('.alert').alert('close'), 5000);
        }

        function updateButtonCounts() {
            const selectedCount = $('.select-checkbox:checked').length;

            $('#restore-button-text').text(`Restore Selected (${selectedCount})`);
            $('#restore-selected')
                .toggleClass('btn-success', selectedCount > 0)
                .toggleClass('btn-secondary', selectedCount === 0)
                .prop('disabled', selectedCount === 0);

            $('#delete-button-text').text(`Delete Permanently (${selectedCount})`);
            $('#delete-selected')
                .toggleClass('btn-danger', selectedCount > 0)
                .toggleClass('btn-secondary', selectedCount === 0)
                .prop('disabled', selectedCount === 0);
        }

        function getSelectedIds() {
            return $('.select-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
        }

        function setButtonLoading($btn, isLoading) {
            if (isLoading) {
                // Store original HTML
                $btn.data('original-html', $btn.html());
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            } else {
                // Restore original HTML
                $btn.prop('disabled', false).html($btn.data('original-html'));
                updateButtonCounts();
            }
        }

        $(document).ready(function() {
            const table = $('#mail-inquiries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mail-inquiries.trash') }}",
                    error: function(xhr, error, thrown) {
                        console.error('DataTable AJAX error:', xhr, error, thrown);
                        showAlert('danger', 'Failed to load trashed inquiries. Please try again.');
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data) {
                            return data ? data : '<span class="text-muted">N/A</span>';
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function(data) {
                            return data ? `<a href="mailto:${data}">${data}</a>` :
                                '<span class="text-muted">N/A</span>';
                        }
                    },
                    {
                        data: 'short_subject',
                        name: 'subject',
                        render: function(data) {
                            return data ? data : '<span class="text-muted">No Subject</span>';
                        }
                    },
                    {
                        data: 'status_badge',
                        name: 'is_read',
                        className: 'text-center'
                    },
                    {
                        data: 'formatted_date',
                        name: 'created_at',
                        className: 'text-center'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [
                    [6, 'desc']
                ],
                language: {
                    emptyTable: "No trashed inquiries found",
                    info: "Showing _START_ to _END_ of _TOTAL_ inquiries",
                    infoEmpty: "Showing 0 to 0 of 0 inquiries",
                    infoFiltered: "(filtered from _MAX_ total inquiries)",
                    lengthMenu: "Show _MENU_ inquiries",
                    search: "Search:",
                    zeroRecords: "No matching inquiries found"
                },
                drawCallback: function() {
                    $('.select-checkbox').prop('checked', false);
                    $('#select-all').prop('checked', false);
                    updateButtonCounts();
                }
            });

            // Select All checkbox
            $('#select-all').on('click', function() {
                const isChecked = this.checked;
                $('.select-checkbox').prop('checked', isChecked);
                updateButtonCounts();
            });

            // Individual checkbox change
            $('#mail-inquiries-table').on('change', '.select-checkbox', function() {
                const total = $('.select-checkbox').length;
                const checked = $('.select-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
                updateButtonCounts();
            });

            // Bulk restore
            $('#restore-selected').on('click', function() {
                const selectedCount = $('.select-checkbox:checked').length;
                if (selectedCount === 0) {
                    showAlert('warning', 'Please select at least one inquiry');
                    return;
                }

                if (confirm(`Restore ${selectedCount} selected inquiry(s)?`)) {
                    const $btn = $(this);
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: "{{ route('mail-inquiries.bulk-restore') }}",
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: getSelectedIds()
                        },
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(function() {
                                $('.select-checkbox').prop('checked', false);
                                $('#select-all').prop('checked', false);
                                updateButtonCounts();
                            }, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to restore inquiries';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            // Bulk delete permanently
            $('#delete-selected').on('click', function() {
                const selectedCount = $('.select-checkbox:checked').length;
                if (selectedCount === 0) {
                    showAlert('warning', 'Please select at least one inquiry');
                    return;
                }

                if (confirm(
                        `Permanently delete ${selectedCount} selected inquiry(s)? This cannot be undone.`
                    )) {
                    const $btn = $(this);
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: "{{ route('mail-inquiries.bulk-destroy') }}",
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: getSelectedIds()
                        },
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(function() {
                                $('.select-checkbox').prop('checked', false);
                                $('#select-all').prop('checked', false);
                                updateButtonCounts();
                            }, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to delete inquiries';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            // Initialize buttons
            updateButtonCounts();

            // Single action handlers using event delegation
            $(document).on('click', '.restore-btn', function(e) {
                e.preventDefault();
                const $form = $(this).closest('form');
                const $btn = $(this);

                if (confirm('Restore this inquiry?')) {
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'PUT',
                        data: $form.serialize(),
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to restore inquiry';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            $(document).on('click', '.delete-permanently-btn', function(e) {
                e.preventDefault();
                const $form = $(this).closest('form');
                const $btn = $(this);

                if (confirm('Permanently delete this inquiry? This cannot be undone.')) {
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'DELETE',
                        data: $form.serialize(),
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to delete inquiry';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });
        });
    </script>
@endpush
