@extends('layouts.backend')

@section('content')
    <div class="container-fluid">

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show auto-hide" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger border-left-danger alert-dismissible fade show auto-hide" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Dynamic Alert Container -->
        <div id="ajax-alert-container"></div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Members</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Member List') }}</h1>
            <a href="{{ route('members.create') }}" class="btn btn-primary btn">
                Create Member
            </a>
        </div>

        <table id="members-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>State</th>
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
            var table = $('#members-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('members.index') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'state',
                        name: 'state'
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
                var memberId = $(this).data('id');
                var $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this member?')) {
                    $.ajax({
                        url: "{{ route('members.destroy', '') }}/" + memberId,
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
                            showAlert('danger', 'An error occurred while deleting the member.');
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
