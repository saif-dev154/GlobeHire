@extends('Admin.layouts.app')

@section('title')
    Agents List
@endsection

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-person-badge me-2"></i> Agent List
        </h5>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="userstable" class="table  table-striped table-bordered" style="width:100%">
                    <thead class="table bg-primary text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Activate/Deactivate</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">{{ $user->role }}</td>
                                <td> <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($user->status) }}
                                    </span></td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST"
                                            class="m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch" data-bs-toggle="tooltip"
                                                title="Click to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    {{ $user->status === 'active' ? 'checked' : '' }}
                                                    onchange="this.form.submit()">
                                            </div>
                                        </form>

                                    </div>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#userstable').DataTable();
        });
    </script>
@endpush
