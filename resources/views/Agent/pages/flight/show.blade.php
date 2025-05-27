{{-- resources/views/agent/pages/visa/show_schedule.blade.php --}}
@extends('agent.layouts.app')

@section('title', 'View Flight Schedule')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded-2 border-0">
    <div class="card-header bg-primary text-white py-2 px-3 d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-eye-fill me-2"></i>
        <h5 class="mb-0 d-inline">Flight Schedule Details</h5>
      </div>
      {{-- <a href="{{ route('agent.visa.flight.edit', [$visa, $schedule]) }}" class="btn btn-sm btn-light">
        <i class="bi bi-pencil-fill me-1"></i>Edit
      </a> --}}
    </div>

    <div class="card-body p-4">
      <div class="row gy-3">
        {{-- Candidate --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Candidate</label>
          <input type="text" class="form-control" value="{{ $visa->contract->interview->application->candidate->name }}" readonly>
        </div>

        {{-- Airline --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Airline</label>
          <input type="text" class="form-control" value="{{ $schedule->airline }}" readonly>
        </div>

        {{-- Flight Number --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Flight Number</label>
          <input type="text" class="form-control" value="{{ $schedule->flight_number ?? '-' }}" readonly>
        </div>

        {{-- Departure --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Departure</label>
          <div class="form-control bg-light">
            <strong>{{ $schedule->departure_datetime->format('d M, Y H:i') }}</strong><br>
            <small>{{ $schedule->departure_airport }}</small>
          </div>
        </div>

        {{-- Arrival --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Arrival</label>
          <div class="form-control bg-light">
            <strong>{{ $schedule->arrival_datetime->format('d M, Y H:i') }}</strong><br>
            <small>{{ $schedule->arrival_airport }}</small>
          </div>
        </div>

        {{-- Ticket --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Ticket</label>
          <div>
            <a href="{{ asset('storage/'.$schedule->ticket_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>
              Download Ticket
            </a>
          </div>
        </div>

        {{-- Sponsorship Letter --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Sponsorship Letter</label>
          <div>
            <a href="{{ asset('storage/'.$schedule->sponsorship_letter_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>
              Download Letter
            </a>
          </div>
        </div>

        {{-- Travel Status --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Travel Status</label>
          <div>
            <span class="badge 
              {{ $schedule->travel_status === 'completed' ? 'bg-success' : '' }}
              {{ $schedule->travel_status === 'cancelled' ? 'bg-danger' : '' }}
              {{ in_array($schedule->travel_status, ['scheduled','ticket_uploaded']) ? 'bg-warning text-dark' : '' }}
            ">
              {{ Str::title(str_replace('_',' ',$schedule->travel_status)) }}
            </span>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <a href="{{ route('agent.visa.schedules') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle me-1"></i>Back to Schedules
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
