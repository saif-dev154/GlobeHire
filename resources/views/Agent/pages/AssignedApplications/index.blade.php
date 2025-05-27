{{-- resources/views/agent/applications/index.blade.php --}}
@extends('agent.layouts.app')

@section('title', 'Assigned Applications')

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <div class="d-flex align-items-center ms-3">
            <i class="bi bi-folder-fill me-2"></i>
            <h5 class="mb-0 fw-bold">My Assigned Applications</h5>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="appsTable" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th class="py-3 border-0">#</th>
                        <th class="py-3 border-0">Job</th>
                        <th class="py-3 border-0">Candidate</th>
                        <th class="py-3 border-0">Applied On</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 border-0">View</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apps as $idx => $app)
                        <tr class="text-center align-middle">
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $app->job->title }}</td>
                            <td>{{ $app->full_name ?? 'N/A' }}</td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge
                                    {{ $app->status === 'pending'    ? 'bg-secondary'
                                    : ($app->status === 'in_review' ? 'bg-info'
                                    : ($app->status === 'approved'  ? 'bg-success'
                                                                   : 'bg-danger')) }}">
                                    {{ ucwords(str_replace('_', ' ', $app->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('agent.applications.show', $app->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(function() {
            $('#appsTable').DataTable({
                dom:
                  '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>' +
                  'tr' +
                  '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                renderer: 'bootstrap'
            });
        });
    </script>
@endpush
