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
                <li class="breadcrumb-item active" aria-current="page">Mail Inquiries</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mail Inquiries</h1>
            <div>
                <button type="button" id="mark-read-selected" class="btn btn-primary mr-2">
                    <span id="mark-read-button-text">Mark as Read (<span class="unread-count">0</span>)</span>
                </button>
                <button type="button" id="mark-unread-selected" class="btn btn-warning mr-2">
                    <span id="mark-unread-button-text">Mark as Unread (<span class="read-count">0</span>)</span>
                </button>
                <button type="button" id="delete-selected" class="btn btn-danger">
                    <span id="delete-button-text">Move to Trash (0)</span>
                </button>
            </div>
        </div>

        <!-- Mail Inquiries Table -->
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

        function updateActionButtons() {
            const selectedCheckboxes = $('.select-checkbox:checked');
            const selectedCount = selectedCheckboxes.length;
            let readCount = 0;
            let unreadCount = 0;

            selectedCheckboxes.each(function() {
                const row = $(this).closest('tr');
                const status = row.attr('data-read-status');
                if (status === 'read') {
                    readCount++;
                } else {
                    unreadCount++;
                }
            });

            $('#mark-read-button-text .unread-count').text(unreadCount);
            $('#mark-unread-button-text .read-count').text(readCount);
            $('#delete-button-text').text(`Move to Trash (${selectedCount})`);

            $('#mark-read-selected')
                .toggleClass('btn-primary', unreadCount > 0)
                .toggleClass('btn-secondary', unreadCount === 0)
                .prop('disabled', unreadCount === 0);

            $('#mark-unread-selected')
                .toggleClass('btn-warning', readCount > 0)
                .toggleClass('btn-secondary', readCount === 0)
                .prop('disabled', readCount === 0);

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
                updateActionButtons();
            }
        }

        $(document).ready(function() {
            const table = $('#mail-inquiries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('mail-inquiries.index') }}",
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
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (type === 'display') return data;
                            return row.is_read ? 'read' : 'unread';
                        }
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
                    emptyTable: "No mail inquiries found",
                    info: "Showing _START_ to _END_ of _TOTAL_ inquiries",
                    infoEmpty: "Showing 0 to 0 of 0 inquiries",
                    infoFiltered: "(filtered from _MAX_ total inquiries)",
                    lengthMenu: "Show _MENU_ inquiries",
                    search: "Search:",
                    zeroRecords: "No matching inquiries found"
                },
                createdRow: function(row, data) {
                    $(row).attr('data-read-status', data.is_read ? 'read' : 'unread');
                },
                drawCallback: function() {
                    $('.select-checkbox').prop('checked', false);
                    $('#select-all').prop('checked', false);
                    updateActionButtons();
                }
            });

            // Select All checkbox
            $('#select-all').on('click', function() {
                const isChecked = this.checked;
                $('.select-checkbox').prop('checked', isChecked);
                updateActionButtons();
            });

            // Individual checkbox change
            $('#mail-inquiries-table').on('change', '.select-checkbox', function() {
                const total = $('.select-checkbox').length;
                const checked = $('.select-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
                updateActionButtons();
            });

            // Bulk mark as read
            $('#mark-read-selected').on('click', function() {
                const unreadCount = parseInt($('#mark-read-button-text .unread-count').text());
                if (unreadCount === 0) {
                    showAlert('warning', 'No unread emails selected');
                    return;
                }

                if (confirm(`Mark ${unreadCount} unread email(s) as read?`)) {
                    const $btn = $(this);
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: "{{ route('mail-inquiries.bulk-mark-read') }}",
                        type: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: getSelectedIds()
                        },
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(function() {
                                $('.select-checkbox').prop('checked', false);
                                $('#select-all').prop('checked', false);
                                updateActionButtons();
                            }, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to mark as read';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            // Bulk mark as unread
            $('#mark-unread-selected').on('click', function() {
                const readCount = parseInt($('#mark-unread-button-text .read-count').text());
                if (readCount === 0) {
                    showAlert('warning', 'No read emails selected');
                    return;
                }

                if (confirm(`Mark ${readCount} read email(s) as unread?`)) {
                    const $btn = $(this);
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: "{{ route('mail-inquiries.bulk-mark-unread') }}",
                        type: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: getSelectedIds()
                        },
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(function() {
                                $('.select-checkbox').prop('checked', false);
                                $('#select-all').prop('checked', false);
                                updateActionButtons();
                            }, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to mark as unread';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            // Bulk move to trash
            $('#delete-selected').on('click', function() {
                const selectedCount = $('.select-checkbox:checked').length;
                if (selectedCount === 0) {
                    showAlert('warning', 'Please select at least one inquiry');
                    return;
                }

                if (confirm(`Move ${selectedCount} selected inquiry(s) to trash?`)) {
                    const $btn = $(this);
                    setButtonLoading($btn, true);

                    $.ajax({
                        url: "{{ route('mail-inquiries.bulk-move-to-trash') }}",
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
                                updateActionButtons();
                            }, false);
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message ||
                                'Failed to move to trash';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            // Initialize buttons
            updateActionButtons();

            // Single action handlers using event delegation
            $(document).on('click', '.mark-read-btn', function(e) {
                e.preventDefault();
                const $form = $(this).closest('form');
                const $btn = $(this);

                if (confirm('Mark this inquiry as read?')) {
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
                                'Failed to mark as read';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            $(document).on('click', '.mark-unread-btn', function(e) {
                e.preventDefault();
                const $form = $(this).closest('form');
                const $btn = $(this);

                if (confirm('Mark this inquiry as unread?')) {
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
                                'Failed to mark as unread';
                            showAlert('danger', errorMsg);
                        },
                        complete: function() {
                            setButtonLoading($btn, false);
                        }
                    });
                }
            });

            $(document).on('click', '.move-to-trash-btn', function(e) {
                e.preventDefault();
                const $form = $(this).closest('form');
                const $btn = $(this);

                if (confirm('Move this inquiry to trash?')) {
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
                                'Failed to move to trash';
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
