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
                <li class="breadcrumb-item"><a href="{{ route('mail-inquiries.index') }}">Mail Inquiries</a></li>
                <li class="breadcrumb-item active" aria-current="page">Trash</li>
            </ol>
        </nav>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Trash</h1>
            <div>
                <button type="button" id="restore-selected" class="btn btn-success mr-2" onclick="confirmBulkRestore()">
                    <span id="restore-button-text">Restore Selected (0)</span>
                </button>
                <button type="button" id="delete-selected" class="btn btn-danger" onclick="confirmBulkDelete()">
                    <span id="delete-button-text">Delete Selected (0)</span>
                </button>
            </div>
        </div>

        <form id="bulk-restore-form" action="{{ route('mail-inquiries.bulk-restore') }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <form id="bulk-delete-form" action="{{ route('mail-inquiries.bulk-destroy') }}" method="POST">
            @csrf
            @method('DELETE')
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
        $(document).ready(function() {
            var table = $('#mail-inquiries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('mail-inquiries.trash') }}",
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
                }
            });

            $('#select-all').on('click', function() {
                $('.select-checkbox').prop('checked', this.checked);
                updateButtonCounts();
            });

            $('#mail-inquiries-table tbody').on('change', '.select-checkbox', function() {
                var total = $('.select-checkbox').length;
                var checked = $('.select-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
                updateButtonCounts();
            });

            function updateButtonCounts() {
                var selectedCount = $('.select-checkbox:checked').length;

                $('#restore-button-text').text('Restore Selected (' + selectedCount + ')');
                $('#restore-selected').toggleClass('btn-success', selectedCount > 0)
                    .toggleClass('btn-secondary', selectedCount === 0);

                $('#delete-button-text').text('Delete Selected (' + selectedCount + ')');
                $('#delete-selected').toggleClass('btn-danger', selectedCount > 0)
                    .toggleClass('btn-secondary', selectedCount === 0);
            }

            updateButtonCounts();
        });

        function confirmBulkRestore() {
            var selectedCount = $('.select-checkbox:checked').length;
            if (selectedCount === 0) {
                alert('Please select at least one inquiry to restore.');
                return;
            }
            if (confirm('Are you sure you want to restore the selected ' + selectedCount + ' inquiry(s)?')) {
                $('#bulk-restore-form').append(
                    $('.select-checkbox:checked').clone()
                ).submit();
            }
        }

        function confirmBulkDelete() {
            var selectedCount = $('.select-checkbox:checked').length;
            if (selectedCount === 0) {
                alert('Please select at least one inquiry to delete.');
                return;
            }
            if (confirm('Are you sure you want to permanently delete the selected ' + selectedCount +
                    ' inquiry(s)? This action cannot be undone.')) {
                $('#bulk-delete-form').append(
                    $('.select-checkbox:checked').clone()
                ).submit();
            }
        }
    </script>
@endpush
