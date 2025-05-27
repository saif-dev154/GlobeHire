@extends('employer.layouts.app')

@section('title','Shortlisted Candidates')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary bg-gradient text-white">
      <h5 class="mb-0">
        <i class="bi bi-people-fill me-2"></i>
        Shortlisted Candidates
      </h5>
    </div>
    <div class="card-body p-0">
      <table class="table table-bordered text-center mb-0">
        <thead class="table-light">
          <tr>
            <th>Candidate</th>
            <th>Job Title</th>
            <th>Interview Status</th>
            <th>Contract Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($shortlisted as $iv)
            <tr>
              <td>{{ $iv->application->full_name }}</td>
              <td>{{ $iv->application->job->title }}</td>
               <td><span class="badge bg-info text-white">{{ ucfirst($iv->status) }}</span></td>
              
                 
 <td>
    {{ optional($iv->contract)->status ?? 'No Contract' }}
</td>


              
              <td>
                <a 
                  href="{{ route('employer.contracts.create', $iv->id) }}" 
                  class="btn btn-sm btn-success"
                >
                  <i class="bi bi-file-earmark-medical-fill me-1"></i>
                  Make Contract
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-muted">No shortlisted candidates.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
