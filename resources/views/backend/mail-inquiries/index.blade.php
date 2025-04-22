@extends('layouts.backend')

@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mail Inquiries</li>
            </ol>
        </nav>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mail Inquiries</h1>
            <div>
                <button type="button" id="mark-read-selected" class="btn btn-primary mr-2"
                    onclick="confirmBulkMarkAsRead()">
                    <span id="mark-read-button-text">Mark as Read (<span class="unread-count">0</span>)</span>
                </button>
                <button type="button" id="mark-unread-selected" class="btn btn-warning mr-2"
                    onclick="confirmBulkMarkAsUnread()">
                    <span id="mark-unread-button-text">Mark as Unread (<span class="read-count">0</span>)</span>
                </button>
                <button type="button" id="delete-selected" class="btn btn-danger" onclick="confirmBulkDelete()">
                    <span id="delete-button-text">Move to Trash (0)</span>
                </button>
            </div>
        </div>

        <form id="bulk-delete-form" action="{{ route('mail-inquiries.bulk-move-to-trash') }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <form id="bulk-mark-read-form" action="{{ route('mail-inquiries.bulk-mark-read') }}" method="POST"
            style="display: none;">
            @csrf
            @method('PUT')
            <input type="hidden" name="ids" id="bulk-mark-read-ids">
        </form>

        <form id="bulk-mark-unread-form" action="{{ route('mail-inquiries.bulk-mark-unread') }}" method="POST"
            style="display: none;">
            @csrf
            @method('PUT')
            <input type="hidden" name="ids" id="bulk-mark-unread-ids">
        </form>

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
        // First define all functions
        function updateActionButtons() {
            var selectedCheckboxes = $('.select-checkbox:checked');
            var selectedCount = selectedCheckboxes.length;

            var readCount = 0;
            var unreadCount = 0;

            selectedCheckboxes.each(function() {
                var row = $(this).closest('tr');
                var status = row.attr('data-read-status');
                if (status === 'read') {
                    readCount++;
                } else {
                    unreadCount++;
                }
            });

            $('#mark-read-button-text .unread-count').text(unreadCount);
            $('#mark-unread-button-text .read-count').text(readCount);
            $('#delete-button-text').text('Move to Trash (' + selectedCount + ')');

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

        function confirmBulkMarkAsRead() {
            var unreadCount = parseInt($('#mark-read-button-text .unread-count').text());
            if (unreadCount === 0) {
                alert('No unread emails selected to mark as read.');
                return;
            }
            if (confirm('Are you sure you want to mark ' + unreadCount + ' unread email(s) as read?')) {
                $('#bulk-mark-read-ids').val(getSelectedIds().join(','));
                $('#bulk-mark-read-form').submit();
            }
        }

        function confirmBulkMarkAsUnread() {
            var readCount = parseInt($('#mark-unread-button-text .read-count').text());
            if (readCount === 0) {
                alert('No read emails selected to mark as unread.');
                return;
            }
            if (confirm('Are you sure you want to mark ' + readCount + ' read email(s) as unread?')) {
                $('#bulk-mark-unread-ids').val(getSelectedIds().join(','));
                $('#bulk-mark-unread-form').submit();
            }
        }

        function confirmBulkDelete() {
            var selectedCount = $('.select-checkbox:checked').length;
            if (selectedCount === 0) {
                alert('Please select at least one inquiry to move to trash.');
                return;
            }
            if (confirm('Are you sure you want to move ' + selectedCount + ' selected inquiry(s) to trash?')) {
                $('#bulk-delete-ids').val(getSelectedIds().join(','));
                $('#bulk-delete-form').submit();
            }
        }

        // Then initialize the DataTable and event handlers
        $(document).ready(function() {
            var table = $('#mail-inquiries-table').DataTable({
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
                            return data ? '<a href="mailto:' + data + '">' + data + '</a>' :
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
                            if (type === 'display') {
                                return data;
                            }
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
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-read-status', data.is_read ? 'read' : 'unread');
                }
            });

            $('#select-all').on('click', function() {
                var isChecked = this.checked;
                $('.select-checkbox').prop('checked', isChecked);
                updateActionButtons();
            });

            $('#mail-inquiries-table tbody').on('change', '.select-checkbox', function() {
                var total = $('.select-checkbox').length;
                var checked = $('.select-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
                updateActionButtons();
            });

            // Initialize buttons
            updateActionButtons();
        });
    </script>
@endpush
