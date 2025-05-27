{{-- resources/views/candidate/pages/jobs/show.blade.php --}}
@extends('candidate.layouts.app')

@section('title', 'Job Details')

@section('content')
<div class="container py-3">
  <div class="card shadow-sm rounded-2 border-0">

    {{-- Header --}}
    <div class="card-header bg-gradient-primary text-white py-2 px-3">
      <h5 class="mb-0 fw-semibold">
        <i class="bi bi-briefcase me-1"></i>{{ $job->title }}
      </h5>
      {{-- <small class="opacity-75">Job ID: {{ $job->id }}</small> --}}
    </div>

    {{-- Body --}}
    <div class="card-body py-3 px-3">
      <div class="row g-4">

        {{-- Left Column --}}
        <div class="col-md-6">
          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-geo-alt-fill text-primary me-2 mt-1"></i>
            <div><strong>Location:</strong> {{ $job->location }}</div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-cash-stack text-primary me-2 mt-1"></i>
            <div>
              <strong>Salary:</strong>
              ${{ number_format($job->salary, 2) }} /
              {{ $job->salary_structure === 'project'
                  ? 'Project'
                  : ucfirst($job->salary_structure) }}
            </div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-person-badge text-primary me-2 mt-1"></i>
            <div><strong>Experience:</strong> {{ ucfirst($job->experience_level) }}</div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-layers text-primary me-2 mt-1"></i>
            <div><strong>Job Type:</strong> {{ ucwords(str_replace('-', ' ', $job->job_type)) }}</div>
          </div>
        </div>

        {{-- Right Column --}}
        <div class="col-md-6">
          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-mortarboard text-primary me-2 mt-1"></i>
            <div><strong>Education:</strong> {{ ucwords(str_replace('_', ' ', $job->education)) }}</div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-info-circle text-primary me-2 mt-1"></i>
            <div><strong>Status:</strong> {{ ucfirst($job->status) }}</div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-calendar2-check text-primary me-2 mt-1"></i>
            <div>
              <strong>Start Date:</strong>
              {{ optional($job->application_start_date)->format('d M Y') ?? '—' }}
            </div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-calendar2-event text-primary me-2 mt-1"></i>
            <div>
              <strong>Deadline:</strong>
              {{ optional($job->application_deadline)->format('d M Y') ?? '—' }}
            </div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-gender-ambiguous text-primary me-2 mt-1"></i>
            <div><strong>Gender:</strong> {{ ucfirst($job->gender) }}</div>
          </div>

          <div class="mb-2 d-flex align-items-start">
            <i class="bi bi-passport text-primary me-2 mt-1"></i>
            <div>
              <strong>Visa Sponsor:</strong>
              {{ $job->visa_sponsor ? 'Yes' : 'No' }}
            </div>
          </div>
        </div>
      </div>

      {{-- Description --}}
      <div class="pt-3">
        <h6 class="fw-semibold small text-uppercase text-white mb-1">Job Description</h6>
        <div class="bg-light p-2 rounded small">
          {!! nl2br(e($job->description)) !!}
        </div>
      </div>

      {{-- Skills: ensure it's an array --}}
      @php
        $skills = is_string($job->required_skills)
                  ? json_decode($job->required_skills, true) ?? []
                  : (array) $job->required_skills;
      @endphp

      <div class="pt-3">
        <h6 class="fw-semibold small text-uppercase text-white mb-1">Required Skills</h6>
        <div class="d-flex flex-wrap gap-1">
          @forelse($skills as $skill)
            <span class="badge bg-primary bg-opacity-10 text-danger border border-primary border-opacity-10 small">
              {{ $skill }}
            </span>
          @empty
            <span class="text-white">No specific skills</span>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Footer with Apply Now --}}
    <div class="card-footer bg-light py-2 px-3 d-flex justify-content-between align-items-center">
      <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
      </a>
      <a href="{{ route('candidate.jobs.apply', $job->id) }}" class="btn btn-success btn-sm">
        <i class="bi bi-send-fill me-1"></i> Apply Now
      </a>
    </div>
  </div>
</div>

<style>
  .bg-gradient-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
  }
  .small { font-size: 0.875rem; }
</style>
@endsection
