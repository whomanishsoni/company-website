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
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Customer List') }}</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn">
                Create User
            </a>
        </div>

        <table id="users-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables will populate this dynamically -->
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        // Define showAlert in the global scope
        function showAlert(type, message) {
            $('#ajax-alert-container').empty();

            var alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

            $('#ajax-alert-container').html(alertHtml);

            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }

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
                ] // Sorting by title column
            });

            // Delete single blog
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

            updateDeleteButton();
        });

        function confirmBulkDelete() {
            var selectedCount = $('.select-checkbox:checked').length;
            if (selectedCount === 0) {
                showAlert('danger', 'No blogs selected. Please select at least one blog to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete the selected ' + selectedCount + ' blog(s)?')) {
                var selectedIds = [];
                $('.select-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                $('#delete-selected').prop('disabled', true);
                $('#delete-selected').html('<i class="fas fa-spinner fa-spin"></i> Deleting...');

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
                            $('#blogs-table').DataTable().ajax.reload(null, false);
                            $('.select-checkbox').prop('checked', false);
                            $('#select-all').prop('checked', false);
                            updateDeleteButton();
                        } else {
                            showAlert('danger', response.message);
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'An error occurred while deleting the blogs.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showAlert('danger', errorMessage);
                    },
                    complete: function() {
                        $('#delete-selected').prop('disabled', false);
                        $('#delete-selected').html('<span id="delete-button-text">Delete Selected (0)</span>');
                    }
                });
            }
        }
    </script>
@endpush
