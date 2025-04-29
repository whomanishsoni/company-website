@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
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
        $(document).ready(function() {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_info',
                        name: 'user_info',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex align-items-center">
                                    <a href="/users/${row.id}/edit" class="d-flex align-items-center text-dark" style="text-decoration: none;">
                                        <img src="${row.photo}" alt="User Photo" class="rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        <span>${row.name}</span>
                                    </a>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                var userId = $(this).data('id');
                var $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: "{{ route('users.destroy', '') }}/" + userId,
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
                            showAlert('danger', 'An error occurred while deleting the user.');
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
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;

                $('#ajax-alert-container').html(alertHtml);

                setTimeout(function() {
                    $('.alert').alert('close');
                }, 5000);
            }
        });
    </script>
@endpush
