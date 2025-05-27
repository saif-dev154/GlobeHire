{{-- resources/views/candidate/applications/index.blade.php --}}
@extends('candidate.layouts.app')

@section('title', 'My Applications')

@push('css/links')
  <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
  <div class="card-header bg-primary bg-gradient text-white   py-3 rounded-top-2">
    <h5 class="mb-0 fw-bold">
      <i class="bi bi-folder-fill me-2 ms-3"></i> My Applications
    </h5>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="applicationstable" class="table table-striped table-bordered" style="width:100%">
          <thead class="bg-primary text-white text-center">
            <tr>
              <th>#</th>
              <th>Job Title</th>
              <th>Applied On</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($applications as $i => $app)
              <tr class="text-center align-middle">
                <td>{{ $i + 1 }}</td>
                <td>{{ $app->job->title }}</td>
                <td>{{ $app->created_at->format('d M Y') }}</td>
                <td>
                  <span class="badge
                    {{ $app->status === 'pending'    ? 'bg-secondary'
                    : ($app->status === 'in_review' ? 'bg-info'
                    : ($app->status === 'approved'  ? 'bg-success'
                                                   : 'bg-danger')) }}">
                    {{ ucwords(str_replace('_',' ',$app->status)) }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('candidate.applications.show', $app->id) }}"
                     class="btn btn-sm btn-info" title="View Details">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">You have not applied to any jobs yet.</td>
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
    $(function() {
      $('#applicationstable').DataTable({
        dom:
          '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>' +
          '<"table-responsive"tr>' +
          '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        renderer: 'bootstrap'
      });
    });
  </script>
@endpush
