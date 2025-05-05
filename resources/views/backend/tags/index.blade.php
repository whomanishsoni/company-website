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
                <li class="breadcrumb-item active" aria-current="page">Tags</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tags</h1>
            <a href="{{ route('tags.create') }}" class="btn btn-primary btn">
                Create Tag
            </a>
        </div>

        <table id="tags-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
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
            var table = $('#tags-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tags.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
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
                var tagId = $(this).data('id');
                var $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this tag?')) {
                    $.ajax({
                        url: "{{ route('tags.destroy', '') }}/" + tagId,
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
                            showAlert('danger', 'An error occurred while deleting the tag.');
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
