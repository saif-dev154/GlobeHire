@extends('candidate.layouts.app')

@section('title', 'View Visa Documents')

@section('content')
<div class="container py-4">
  <h3 class="mb-4 text-center text-primary">
    <i class="bi bi-folder-symlink-fill me-2"></i>
    View Visa Documents
  </h3>

  <div class="card shadow-sm border-primary mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-0">
          <i class="bi bi-person-badge-fill me-2"></i>
          {{ $visa->contract->interview->application->candidate->name }}
        </h5>
        <small>
          Interview Date:
          {{ optional($visa->contract->interview->interview_date)->format('M d, Y') }}
        </small>
      </div>
      <span class="badge bg-primary text-white fs-6 px-4 py-2 rounded">
        Contract #{{ $visa->contract_id }}
      </span>
    </div>
  </div>

  <div class="row g-4">
    @foreach($fields as $f)
      <div class="col-md-4">
        <div class="card text-white bg-dark h-100 shadow-sm">
          <div class="card-body d-flex flex-column text-center">
            <i class="bi {{ $f['icon'] }} display-5 mb-3 text-info"></i>
            <h6 class="card-title mb-2">{{ $f['label'] }}</h6>

            @if($f['path'])
              <a href="{{ asset('storage/'.$f['path']) }}"
                 target="_blank"
                 class="text-light small mb-2 d-block text-truncate"
                 title="{{ $f['filename'] }}">
                <i class="bi bi-eye-fill me-1"></i>{{ $f['filename'] }}
              </a>
            @else
              <span class="text-white small mb-2 d-block">Not uploaded</span>
            @endif

            <span class="badge
              {{ $f['status'] === 'approved' ? 'bg-success'
              : ($f['status'] === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
              {{ ucfirst($f['status']) }}
            </span>

            @if($f['status'] === 'rejected' && $f['remarks'])
              <div class="mt-3 px-2 text-start">
                <small class="text-white">Remark:</small>
                <blockquote class="blockquote text-white small mb-0">
                  {{ $f['remarks'] }}
                </blockquote>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>

  @if(
    collect($visa->getAttributes())
      ->filter(fn($v, $k) => str_ends_with($k, '_status') && $v === 'rejected')
      ->isNotEmpty()
  )
    <div class="text-center mt-4">
      <a href="{{ route('candidate.visa.edit', $visa) }}" class="btn btn-primary">
        <i class="bi bi-pencil-fill me-1"></i>Edit Rejected Files
      </a>
    </div>
  @endif
</div>
@endsection
