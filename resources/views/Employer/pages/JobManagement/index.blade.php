@extends('employer.layouts.app')

@section('title', 'Jobs List')

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
       <h5 class="mb-0 fw-bold">
            <i class="bi bi-briefcase-fill me-2"></i> Job Posts
        </h5>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="jobstable" class="table table-striped table-bordered" style="width:100%">
                    <thead class="table bg-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Type</th>
                            <th>Experience</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $index => $job)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->location }}</td>
                                <td>{{ number_format($job->salary, 2) }}</td>
                                <td class="text-capitalize">{{ str_replace('-', ' ', $job->job_type) }}</td>
                                <td class="text-capitalize">{{ str_replace('_', ' ', $job->experience_level) }}</td>
                                <td>{{ $job->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn btn-sm btn-info me-1" title="View">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this job?')"
                                                title="Delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-white">No jobs found.</td>
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
            $('#jobstable').DataTable({
                // dom: length + filter on first row, table itself, info + pagination on last row
                dom:
                    '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>' +
                    '<"table-responsive"tr>' +
                    '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                // optional: preserve Bootstrap styling
                renderer: 'bootstrap'
            });
        });
    </script>
@endpush
