@extends('layouts.backend')

@section('content')
<!-- Begin Page Content -->
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
                <th>#</th> <!-- Changed from ID to # for the counter -->
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables will populate this dynamically -->
        </tbody>
    </table>

</div>

<!-- /.container-fluid -->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']] // Default sorting by the 'name' column
        });
    });
</script>
@endpush