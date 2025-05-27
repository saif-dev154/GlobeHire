@extends('candidate.layouts.app')

@section('title', 'Interview Details')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
      <span>
       <strong> <i class="bi bi-briefcase-fill me-2"></i>
        Interview For: {{ $job->title }}
        </strong>
      </span>
    </div>

    <div class="card-body">
      {{-- Candidate Details --}}
      <div class="mb-4">
        <h5 class="mb-3 text-primary">
          <i class="bi bi-person-lines-fill me-2"></i>Candidate Details
        </h5>
        <div class="row">
          <div class="col-md-6 mb-2"><strong>Name:</strong> {{ $app->full_name }}</div>
          <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $app->email }}</div>
          <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $app->phone }}</div>
          <div class="col-md-6 mb-2"><strong>Country:</strong> {{ $app->country }}</div>
          @if($app->resume_path)
            <div class="col-12">
              <strong>Resume:</strong>
              <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank">Download CV</a>
            </div>
          @endif
        </div>
      </div>

      {{-- Job & Interview Info --}}
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="border rounded p-3 h-100">
            <h6 class="text-success">
              <i class="bi bi-briefcase-fill me-2"></i>Job Information
            </h6>
            <p class="mb-2"><strong>Position:</strong> {{ $job->title }}</p>
            <p class="mb-0"><strong>Location:</strong> {{ $job->location }}</p>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="border rounded p-3 h-100">
            <h6 class="text-warning">
              <i class="bi bi-calendar-check-fill me-2"></i>Interview Details
            </h6>

            <p class="mb-2">
              <strong>Date:</strong>
              <span id="iv-date-label">{{ $label }}</span>
              <small>( {{ $interview->interview_date->format('d M Y') }} )</small>
            </p>
            <p class="mb-2">
              <strong>Time:</strong> <span id="iv-time">{{ $startFmt }} – {{ $endFmt }}</span>
            </p>
            <p class="mb-2">
              <strong>Progress:</strong>
              <span id="iv-progress" class="badge {{ $progressBadge }}">{{ $progress }}</span>
            </p>
            <p class="mb-2">
              <strong>Result:</strong>
              <span id="iv-result" class="badge {{ $resultBadge }}">{{ $result }}</span>
            </p>

            <div id="iv-meeting-action">
              @if($progress === 'In Progress')
                <a href="{{ $interview->meeting_link }}"
                   class="btn btn-sm btn-success mt-2"
                   target="_blank">
                  <i class="bi bi-camera-video-fill me-1"></i> Join Meeting
                </a>
              @elseif($progress === 'Pending')
                <p class="text-white mb-0">
                  <i class="bi bi-clock me-1"></i> Interview Pending
                </p>
              @else
                <p class="text-danger mb-0">
                  <i class="bi bi-x-circle me-1"></i> Interview Ended
                </p>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Interviewer & Feedback --}}
      <div class="row">
        @if($agent)
          <div class="col-md-6 mb-4">
            <div class="border rounded p-3 h-100">
              <h6 class="text-info">
                <i class="bi bi-person-badge-fill me-2"></i>Interviewer
              </h6>
              <p class="mb-2"><strong>Name:</strong> {{ $agent->name }}</p>
              <p class="mb-0"><strong>Email:</strong> {{ $agent->email }}</p>
            </div>
          </div>
        @endif

        @if($app->remarks || $app->candidate_feedback)
          <div class="col-md-6 mb-4">
            <div class="border rounded p-3 h-100">
              <h6 class="text-secondary">
                <i class="bi bi-chat-left-text-fill me-2"></i>Notes & Feedback
              </h6>
              @if($app->remarks)
                <p class="mb-3"><strong>Remarks:</strong><br>{{ $app->remarks }}</p>
              @endif
               
            </div>
          </div>
        @endif
      </div>

      <div class="text-end">
        <a href="{{ route('candidate.interviews.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Back to Interviews
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
(function() {
  const statusUrl = "{{ route('candidate.interviews.status', $interview->id) }}";

  function refresh() {
    axios.get(statusUrl).then(({ data }) => {
      document.getElementById('iv-date-label').textContent    = data.label;
      document.getElementById('iv-time').textContent         = data.start + ' – ' + data.end;

      const p = document.getElementById('iv-progress');
      p.textContent = data.progress;
      p.className   = 'badge ' + data.progressBadge;

      const r = document.getElementById('iv-result');
      r.textContent = data.result;
      r.className   = 'badge ' + data.resultBadge;

      const c = document.getElementById('iv-meeting-action');
      if (data.progress === 'In Progress') {
        c.innerHTML = `<a href="${data.meeting}"
                          class="btn btn-sm btn-success mt-2"
                          target="_blank">
                         <i class="bi bi-camera-video-fill me-1"></i> Join Meeting
                       </a>`;
      } else if (data.progress === 'Pending') {
        c.innerHTML = `<p class="text-white mb-0">
                         <i class="bi bi-clock me-1"></i> Interview Pending
                       </p>`;
      } else {
        c.innerHTML = `<p class="text-danger mb-0">
                         <i class="bi bi-x-circle me-1"></i> Interview Ended
                       </p>`;
      }
    }).catch(console.error);
  }

  setInterval(refresh, 10000);
})();
</script>
@endpush
