{{-- resources/views/candidate/contracts/sign.blade.php --}}
@extends('candidate.layouts.app')

@section('title','Sign Your Contract')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded">
    <div class="card-header bg-primary text-white d-flex align-items-center">
      <i class="bi bi-file-earmark-text-fill me-2"></i>
      <h5 class="mb-0">Contract Agreement</h5>
    </div>
    <div class="card-body">

      {{-- Key Contract Details --}}
      <div class="row g-3 mb-4">
        @foreach($details as $label => $value)
          <div class="col-6 col-md-4">
            <div class="card h-100 border-start border-3 border-primary shadow-sm hover-shadow">
              <div class="card-body py-2 px-2 text-center">
                <div class="small text-uppercase text-warning">{{ $label }}</div>
                <div class="fw-semibold">{{ $value }}</div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Contract Body --}}
      <div class="mb-4">
        <h6 class="text-secondary text-uppercase mb-1">Contract Terms</h6>
        <div class="p-3 border rounded bg-light">
          {!! nl2br(e($contract->body)) !!}
        </div>
      </div>

      @if($contract->status === 'created')
        <form action="{{ route('candidate.contracts.storeSignature', $contract->id) }}"
              method="POST" onsubmit="prepareSignature()">
          @csrf

          <div class="mb-3">
            <label class="form-label text-secondary text-uppercase small">Please sign below:</label>
            <div class="border rounded p-2">
              <canvas id="signature-pad" class="w-100" style="height:200px;"></canvas>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" id="clear-signature">
              <i class="bi bi-trash-fill"></i> Clear
            </button>
          </div>

          <input type="hidden" name="signature" id="signature">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle-fill me-1"></i> Submit Signature
          </button>
        </form>

      @elseif($contract->status === 'signed')
        <div class="mb-4">
          <h6 class="text-secondary text-uppercase mb-1">Your Signature</h6>
          <img src="{{ asset('storage/'.$contract->signature_path) }}"
               alt="Your Signature"
               class="img-fluid border rounded">
        </div>

      @elseif($contract->status === 'approved')
        <div class="alert alert-success">
          This contract has been <strong>approved</strong>.
        </div>
      @endif

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
  const canvas = document.getElementById('signature-pad'),
        pad    = new SignaturePad(canvas, {
          backgroundColor:'rgba(255,255,255,0)',
          penColor:'rgb(0,0,0)'
        });

  function resizeCanvas(){
    const ratio = Math.max(window.devicePixelRatio||1,1);
    canvas.width  = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    pad.clear();
  }
  window.addEventListener("resize", resizeCanvas);
  resizeCanvas();

  document.getElementById('clear-signature')
          .addEventListener('click', () => pad.clear());

  function prepareSignature(){
    if(pad.isEmpty()){
      alert('Please sign the contract.');
      event.preventDefault();
    } else {
      document.getElementById('signature').value = pad.toDataURL();
    }
  }
</script>
@endpush

@push('styles')
<style>
  .hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    transform: translateY(-2px);
    transition: all .2s ease-in-out;
  }
</style>
@endpush
