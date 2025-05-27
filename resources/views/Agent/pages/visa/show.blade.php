@extends('agent.layouts.app')

@section('title', 'Review Visa Documents')

@section('content')
<div class="container py-4">

  <div class="card shadow-sm border-primary mb-4">
    <div class="card-header bg-primary text-white">
      <div class="row align-items-center justify-content-between">
        <!-- Left: Heading and Interview Date -->
        <div class="col-md-9">
          <h4 class="mb-1">
            <i class="bi bi-folder-symlink-fill me-2"></i> Review Visa Documents
          </h4>
          <small>
            Interview Date:
            {{ optional($visa->contract->interview->interview_date)->format('M d, Y') }}
          </small>
        </div>

        <!-- Right: Contract ID -->
        <div class="col-md-3 text-end">
        <span class="badge bg-primary text-white fs-6 px-4 py-2 rounded">
        Contract #{{ $visa->contract_id }}
      </span>
        </div>
      </div>
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
                 class="text-light small mb-1 d-block text-truncate"
                 title="{{ $f['filename'] }}">
                {{ $f['filename'] }}
              </a>
            @else
              <span class="text-white small mb-1 d-block">Not uploaded</span>
            @endif

            <span class="badge 
              {{ $f['status']==='approved' ? 'bg-success'
               : ($f['status']==='rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
              {{ ucfirst($f['status']) }}
            </span>

            @if($f['status']==='rejected' && $f['remarks'])
              <div class="mt-2 px-2">
                <small class="text-white">Remark:</small>
                <blockquote class="blockquote text-white small">
                  {{ $f['remarks'] }}
                </blockquote>
              </div>
            @endif

            <div class="mt-auto d-flex justify-content-center gap-2">
              <form action="{{ route('agent.visa.approve',['visa'=>$visa->id,'field'=>$f['slug']]) }}"
                    method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-sm btn-success"
                        {{ $f['status']==='approved' ? 'disabled' : '' }}>
                  <i class="bi bi-check2"></i> Approve
                </button>
              </form>

              <button type="button"
                      class="btn btn-sm btn-danger btn-reject"
                      data-action="{{ route('agent.visa.reject',['visa'=>$visa->id,'field'=>$f['slug']]) }}"
                      {{ $f['status']==='rejected' ? 'disabled' : '' }}>
                <i class="bi bi-x-lg"></i> Reject
              </button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

{{-- Remarks Modal --}}
<div class="modal fade" id="remarkModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="remarkForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Remark</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="modalRemarks" class="form-label">Remarks</label>
            <textarea id="modalRemarks" name="remarks" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Submit Rejection</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  let remarkModal = new bootstrap.Modal(document.getElementById('remarkModal'));
  document.querySelectorAll('.btn-reject').forEach(btn => {
    btn.addEventListener('click', function(e){
      e.preventDefault();
      document.getElementById('remarkForm').action = this.dataset.action;
      remarkModal.show();
    });
  });
});
</script>
@endpush
