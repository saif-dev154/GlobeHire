@extends('employer.layouts.app')

@section('title','Contract Signature')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded">
    <div class="card-header bg-primary text-white d-flex align-items-center">
      <i class="bi bi-file-earmark-text-fill me-2"></i>
      <h5 class="mb-0">Contract #{{ $contract->id }}</h5>
    </div>
    <div class="card-body">

      {{-- Key Details as Enhanced Cards --}}
      <div class="row g-3 mb-4">
        @foreach($details as $label => $value)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-start border-3 border-primary shadow-sm hover-shadow">
              <div class="card-body py-3 px-2 text-center">
                <div class="small text-uppercase text-warning">{{ $label }}</div>
                <div class="fw-bold">{{ $value }}</div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Termination Terms --}}
      <div class="mb-4">
        <h6 class="text-white text-uppercase mb-1">Termination Terms</h6>
        <div class="p-3 border rounded bg-light">
          {!! nl2br(e($contract->termination_terms)) !!}
        </div>
      </div>

      {{-- Contract Body --}}
      <div class="mb-4">
        <h6 class="text-white text-uppercase mb-1">Contract Body</h6>
        <div class="p-3 border rounded bg-light">
          {!! nl2br(e($contract->body)) !!}
        </div>
      </div>

      {{-- Signature --}}
      <div class="mb-4 text-center">
        <h6 class="text-white text-uppercase mb-2">Candidate Signature</h6>
        <img src="{{ asset('storage/'.$contract->signature_path) }}"
             alt="Signature of {{ $contract->interview->application->full_name }}"
             class="img-fluid border rounded" style="max-width: 680px;">
      </div>

      {{-- Actions --}}
      <div class="d-flex justify-content-center gap-2">
        @if($contract->status === 'signed')
          <form action="{{ route('employer.contracts.approve', $contract) }}" method="POST">
            @csrf
            <button class="btn btn-success">
              <i class="bi bi-check-circle me-1"></i> Approve
            </button>
          </form>
          <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="bi bi-x-circle me-1"></i> Reject
          </button>
        @elseif($contract->status === 'approved')
          <div class="alert alert-success mb-0">
            This contract is already <strong>approved</strong>.
          </div>
        @endif
      </div>

    </div>
  </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('employer.contracts.reject', $contract) }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reject Contract</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label for="remarks" class="form-label small text-uppercase">Remarks</label>
          <textarea name="remarks" id="remarks" class="form-control" rows="4" required></textarea>
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

@push('styles')
<style>
  .hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    transform: translateY(-2px);
    transition: all .2s ease-in-out;
  }
</style>
@endpush
