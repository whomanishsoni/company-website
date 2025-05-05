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

        <!-- Dynamic Alert Container -->
        <div id="ajax-alert-container"></div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blogs</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Blogs</h1>
            <div>
                <button type="button" id="delete-selected" class="btn btn-danger mr-2" onclick="confirmBulkDelete()">
                    <span id="delete-button-text">Delete Selected (0)</span>
                </button>
                <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                    Create Blog
                </a>
            </div>
        </div>

        <form id="bulk-delete-form" action="{{ route('blogs.bulkDelete') }}" method="POST">
            @csrf
            @method('DELETE')
            <table id="blogs-table" class="table">
                <thead>
                    <tr>
                        <th width="20">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this dynamically -->
                </tbody>
            </table>
        </form>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#blogs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('blogs.index') }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return data ?
                                '<img src="' + data +
                                '" alt="Blog Image" width="60" class="img-thumbnail">' :
                                '<span class="text-muted">No Image</span>';
                        }
                    },
                    {
                        data: 'title',
                        name: 'title',
                        render: function(data, type, row) {
                            const wordLimit = 15;
                            const words = data.split(' ');
                            const limitedTitle = words.length > wordLimit ? words.slice(0,
                                wordLimit).join(' ') + '…' : data;
                            const url = `/blogs/${row.id}/edit`;
                            return `<a href="${url}" class="text-dark" style="text-decoration: none;">${limitedTitle}</a>`;
                        }
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [3, 'asc']
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                var blogId = $(this).data('id');
                var $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this blog?')) {
                    $.ajax({
                        url: "{{ route('blogs.destroy', '') }}/" + blogId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message);
                                table.row($row).remove().draw(false);
                            } else {
                                showAlert('danger', response.message);
                            }
                        },
                        error: function(xhr) {
                            showAlert('danger', 'An error occurred while deleting the blog.');
                        }
                    });
                }
            });

            function showAlert(type, message) {
                $('#ajax-alert-container').empty();
                var alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                `;
                $('#ajax-alert-container').html(alertHtml);
                setTimeout(function() {
                    $('.alert').alert('close');
                }, 5000);
            }

            // Select All
            $('#select-all').on('click', function() {
                $('.select-checkbox').prop('checked', this.checked);
                updateDeleteButton();
            });

            // Individual checkbox
            $('#blogs-table tbody').on('change', '.select-checkbox', function() {
                var total = $('.select-checkbox').length;
                var checked = $('.select-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
                updateDeleteButton();
            });

            function updateDeleteButton() {
                var selectedCount = $('.select-checkbox:checked').length;
                $('#delete-button-text').text('Delete Selected (' + selectedCount + ')');
                if (selectedCount > 0) {
                    $('#delete-selected').removeClass('btn-secondary').addClass('btn-danger');
                } else {
                    $('#delete-selected').removeClass('btn-danger').addClass('btn-secondary');
                }
            }

            // Bulk Delete with AJAX
            window.confirmBulkDelete = function() {
                var selectedIds = $('.select-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) {
                    showAlert('warning', 'No blogs selected. Please select at least one blog to delete.');
                    return;
                }

                if (confirm('Are you sure you want to delete the selected ' + selectedIds.length +
                    ' blog(s)?')) {
                    $.ajax({
                        url: "{{ route('blogs.bulkDelete') }}",
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            selected_ids: selectedIds
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message);
                                table.ajax.reload(function() {
                                    // Reset select-all checkbox and update button after reload
                                    $('#select-all').prop('checked', false);
                                    updateDeleteButton();
                                }, false); // Reload DataTable without resetting pagination
                            } else {
                                showAlert('danger', response.message);
                            }
                        },
                        error: function(xhr) {
                            showAlert('danger',
                                'An error occurred while deleting the selected blogs.');
                        }
                    });
                }
            };

            // Ensure button is updated after table draw
            table.on('draw', function() {
                updateDeleteButton();
            });

            updateDeleteButton();
        });
    </script>
@endpush
