@extends('candidate.layouts.app')

@section('title', 'Flight Schedule Details')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded-2 border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-eye-fill me-2"></i>
        <h5 class="mb-0">Flight Schedule Details</h5>
      </div>
      <a href="{{ route('candidate.visa.flights.index', $visa) }}" class="btn btn-sm btn-light">
        <i class="bi bi-arrow-left-circle me-1"></i>Back to List
      </a>
    </div>
    <div class="card-body p-4">
      <div class="row gy-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Airline</label>
          <input type="text" class="form-control" value="{{ $schedule->airline }}" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Flight Number</label>
          <input type="text" class="form-control" value="{{ $schedule->flight_number ?? '-' }}" readonly>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Departure</label>
          <div class="form-control bg-light">
            <strong>{{ $schedule->departure_datetime->format('d M, Y H:i') }}</strong><br>
            <small>{{ $schedule->departure_airport }}</small>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Arrival</label>
          <div class="form-control bg-light">
            <strong>{{ $schedule->arrival_datetime->format('d M, Y H:i') }}</strong><br>
            <small>{{ $schedule->arrival_airport }}</small>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Ticket</label>
          <div>
            <a href="{{ asset('storage/'.$schedule->ticket_path) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary">
              <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>Download Ticket
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Sponsorship Letter</label>
          <div>
            <a href="{{ asset('storage/'.$schedule->sponsorship_letter_path) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary">
              <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>Download Letter
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Travel Status</label>
          <div>
            <span class="badge 
              {{ $schedule->travel_status==='completed'   ? 'bg-success' : '' }}
              {{ $schedule->travel_status==='cancelled'   ? 'bg-danger'  : '' }}
              {{ in_array($schedule->travel_status, ['scheduled','ticket_uploaded']) ? 'bg-warning text-dark' : '' }}
              {{ $schedule->travel_status==='boarding'    ? 'bg-info text-white'   : '' }}
            ">
              {{ Str::title(str_replace('_',' ',$schedule->travel_status)) }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
