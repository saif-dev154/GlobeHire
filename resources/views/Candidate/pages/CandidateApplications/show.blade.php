@extends('candidate.layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="container py-3">
  <div class="card shadow-sm rounded-2 border-0">

    {{-- Header --}}
    <div class="card-header bg-gradient-primary text-white py-2 px-3">
      <h5 class="mb-0 fw-semibold d-flex align-items-center">
        <i class="bi bi-folder2-open-fill me-2"></i> {{ $application->job->title }}
      </h5>
      <small class="opacity-75">Job ID: {{ $application->job->id }}</small>
    </div>

    {{-- Body --}}
    <div class="card-body py-3 px-3">

      {{-- Applied On & Status --}}
      <div class="row g-4 mb-3">
        <div class="col-md-6 d-flex align-items-start">
          <i class="bi bi-calendar-check-fill text-primary me-2 mt-1"></i>
          <div>
            <strong>Applied On:</strong><br>
            {{ $application->created_at->format('d M Y') }}
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-start">
          <i class="bi bi-info-circle-fill text-primary me-2 mt-1"></i>
          <div>
            <strong>Status:</strong><br>
            <span class="badge
              {{ $application->status==='pending'    ? 'bg-secondary'
              : ($application->status==='in_review'  ? 'bg-info'
              : ($application->status==='approved'   ? 'bg-success'
                                                     : 'bg-danger')) }}">
              {{ ucwords(str_replace('_',' ',$application->status)) }}
            </span>
          </div>
        </div>
      </div>

      {{-- Required Skills --}}
      <div class="pt-3">
        <h6 class="fw-semibold small text-uppercase text-white mb-1">Required Skills</h6>
        <div class="d-flex flex-wrap gap-1 mb-3">
          @foreach($application->job->required_skills as $skill)
            @if(in_array($skill, $application->skills))
              <span class="badge bg-success text-white small">
                {{ ucfirst($skill) }}
              </span>
            @else
              <span class="badge bg-danger text-white small">
                {{ ucfirst($skill) }}
              </span>
            @endif
          @endforeach
        </div>
      </div>

      {{-- Personal & Contact Info --}}
      <div class="row g-4">
        <div class="col-md-6">
          <h6 class="fw-semibold small text-uppercase text-white mb-1">Personal Information</h6>
          <ul class="list-unstyled mb-0">
            <li><strong>Full Name:</strong> {{ $application->full_name }}</li>
            <li><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($application->date_of_birth)->format('d M Y') }}</li>
            <li><strong>Gender:</strong> {{ ucfirst($application->gender) }}</li>
            <li><strong>Nationality:</strong> {{ $application->nationality }}</li>
          </ul>
        </div>
        <div class="col-md-6">
          <h6 class="fw-semibold small text-uppercase text-white mb-1">Contact Details</h6>
          <ul class="list-unstyled mb-0">
            <li><strong>Email:</strong> {{ $application->email }}</li>
            <li><strong>Phone:</strong> {{ $application->phone }}</li>
            <li><strong>Address:</strong> {{ $application->address }}</li>
            <li><strong>Country:</strong> {{ $application->country }}</li>
          </ul>
        </div>
      </div>

      {{-- Education & Experience --}}
      <div class="row g-4 mt-3">
        <div class="col-md-6">
          <h6 class="fw-semibold small text-uppercase text-white mb-1">Educational Background</h6>
          <ul class="list-unstyled mb-0">
            <li><strong>Degree:</strong> {{ ucwords(str_replace('_',' ',$application->highest_degree)) }}</li>
            <li><strong>Institution:</strong> {{ $application->institution }}</li>
            <li><strong>Field of Study:</strong> {{ $application->field_of_study }}</li>
            <li>
              <strong>Graduation Date:</strong><br>
              {{ $application->graduation_date
                  ? \Carbon\Carbon::parse($application->graduation_date)->format('d M Y')
                  : '—' }}
            </li>
          </ul>
        </div>
        <div class="col-md-6">
          <h6 class="fw-semibold small text-uppercase text-white mb-1">Work Experience</h6>
          <ul class="list-unstyled mb-0">
            <li><strong>Years Exp.:</strong> {{ $application->years_experience }}</li>
            <li><strong>Last Employer:</strong> {{ $application->last_employer ?? '—' }}</li>
            <li><strong>Position Held:</strong> {{ $application->last_position ?? '—' }}</li>
            <li><strong>Duration:</strong> {{ $application->employment_duration ?? '—' }}</li>
          </ul>
        </div>
      </div>

      {{-- Additional Info --}}
      <div class="pt-3">
        <h6 class="fw-semibold small text-uppercase text-white mb-1">Additional Information</h6>
        <div class="bg-light p-2 rounded small mb-3">
          <strong>Cover Letter:</strong><br>
          {!! nl2br(e($application->cover_letter ?? '—')) !!}
        </div>
        <div class="row g-4">
          <div class="col-md-6">
            <strong>LinkedIn:</strong><br>
            @if($application->linkedin)
              <a href="{{ $application->linkedin }}" target="_blank">{{ $application->linkedin }}</a>
            @else — @endif
          </div>
          <div class="col-md-6">
            <strong>Portfolio:</strong><br>
            @if($application->portfolio)
              <a href="{{ $application->portfolio }}" target="_blank">{{ $application->portfolio }}</a>
            @else — @endif
          </div>
        </div>
      </div>

      {{-- Attachments --}}
      <div class="pt-3">
        <h6 class="fw-semibold small text-uppercase text-white mb-1">Attachments</h6>
        <ul class="list-unstyled mb-0">
          <li>
            <i class="bi bi-file-earmark-text-fill me-1"></i>
            <strong>Resume:</strong>
            <a href="{{ asset('storage/' . $application->resume) }}" target="_blank">Download</a>
          </li>
          @if(!empty($application->other_docs))
            @foreach($application->other_docs as $doc)
              <li>
                <i class="bi bi-file-earmark-text-fill me-1"></i>
                <strong>Other Document:</strong>
                <a href="{{ asset('storage/' . $doc) }}" target="_blank">Download</a>
              </li>
            @endforeach
          @endif
        </ul>
      </div>
    </div>

    {{-- Footer --}}
    <div class="card-footer bg-light py-2 px-3 d-flex justify-content-between align-items-center">
      <small class="text-muted">
        <i class="bi bi-clock me-1"></i>
        Applied: {{ $application->created_at->format('d M Y, h:i A') }}<br>
        Updated: {{ $application->updated_at->format('d M Y, h:i A') }}
      </small>
      <a href="{{ route('candidate.applications.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
      </a>
    </div>
  </div>
</div>

<style>
  .bg-gradient-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
  }
  .small {
    font-size: 0.875rem;
  }
</style>
@endsection
