@extends('candidate.layouts.app')

@section('title')
    Job Listning
@endsection

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    <div class="card-header bg-primary bg-gradient text-white py-3 rounded-top-2">
       <h5 class="mb-0 fw-bold">
            <i class="bi bi-briefcase-fill me-2 ms-3"></i> Job Listing
        </h5>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="userstable" class="table  table-striped table-bordered" style="width:100%">
                    <thead class="table bg-primary text-center">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Location</th>
                        <th scope="col">Salary</th>
                        <th scope="col">Type</th>
                        <th scope="col">Experience</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                          @forelse($jobs as $index => $job)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ number_format($job->salary, 2) }}</td>
                            <td class="text-capitalize">{{ str_replace('-', ' ', $job->job_type) }}</td>
                            <td class="text-capitalize">{{ str_replace('_', ' ', $job->experience_level) }}</td>
                            <td>{{ $job->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('candidate.jobs.show', $job->id) }}"
                                   class="btn btn-sm btn-info"
                                   title="View">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No active jobs available.</td>
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
