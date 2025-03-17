@extends('layouts.backend')

@section('content')
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
    $(document).ready(function () {
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('members.index') }}", // The endpoint for fetching members data
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'city', name: 'city' },
                { data: 'state', name: 'state' },  // Change from 'state.name' to 'state'
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']] // Ordering the table by the 'name' column by default
        });
    });
</script>
@endpush