{{-- resources/views/agent/pages/visa/schedule.blade.php --}}
@extends('agent.layouts.app')

@php
  // Ensure $schedule always exists
  $schedule = $schedule ?? null;
  $isEdit   = $schedule !== null;
  $action   = $isEdit
    ? route('agent.visa.flight.update', [$visa, $schedule])
    : route('agent.visa.flight.store', $visa);
  $method   = $isEdit ? 'PUT' : 'POST';
@endphp

@section('title', $isEdit ? 'Edit Flight Schedule' : 'Schedule Flight')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded-2 border-0">
    <div class="card-header bg-primary text-white py-2 px-3">
      <h5 class="mb-0 fw-semibold">
        <i class="bi bi-calendar-plus-fill me-1"></i>
        {{ $isEdit ? 'Edit Flight Schedule' : 'Schedule Flight Details' }}
      </h5>
      <small class="opacity-75">Contract #: {{ $visa->contract_id }}</small>
    </div>

    <div class="card-body p-4">
      <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method($method) @endif

        <div class="row gy-4">
          {{-- Candidate --}}
          <div class="col-12">
            <label class="form-label fw-semibold">Candidate</label>
            <input type="text"
                   class="form-control"
                   value="{{ $visa->contract->interview->application->candidate->name }}"
                   readonly>
          </div>

          {{-- Airline Name --}}
          <div class="col-md-6">
            <label for="airline" class="form-label">
              Airline Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="airline"
                   name="airline"
                   class="form-control @error('airline') is-invalid @enderror"
                   value="{{ old('airline', $schedule->airline ?? '') }}"
                   required>
            @error('airline') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Flight Number --}}
          <div class="col-md-6">
            <label for="flight_number" class="form-label">
              Flight Number (optional)
            </label>
            <input type="text"
                   id="flight_number"
                   name="flight_number"
                   class="form-control @error('flight_number') is-invalid @enderror"
                   value="{{ old('flight_number', $schedule->flight_number ?? '') }}">
            @error('flight_number') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Departure Airport --}}
          <div class="col-md-6">
            <label for="departure_airport" class="form-label">
              Departure Airport <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="departure_airport"
                   name="departure_airport"
                   class="form-control @error('departure_airport') is-invalid @enderror"
                   value="{{ old('departure_airport', $schedule->departure_airport ?? '') }}"
                   required>
            @error('departure_airport') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Arrival Airport --}}
          <div class="col-md-6">
            <label for="arrival_airport" class="form-label">
              Arrival Airport <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="arrival_airport"
                   name="arrival_airport"
                   class="form-control @error('arrival_airport') is-invalid @enderror"
                   value="{{ old('arrival_airport', $schedule->arrival_airport ?? '') }}"
                   required>
            @error('arrival_airport') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Departure Date & Time --}}
          <div class="col-md-6">
            <label for="departure_datetime" class="form-label">
              Departure Date & Time <span class="text-danger">*</span>
            </label>
            <input type="datetime-local"
                   id="departure_datetime"
                   name="departure_datetime"
                   class="form-control @error('departure_datetime') is-invalid @enderror"
                   value="{{ old('departure_datetime', optional(optional($schedule)->departure_datetime)->format('Y-m-d\TH:i')) }}"
                   required>
            @error('departure_datetime') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Arrival Date & Time --}}
          <div class="col-md-6">
            <label for="arrival_datetime" class="form-label">
              Arrival Date & Time <span class="text-danger">*</span>
            </label>
            <input type="datetime-local"
                   id="arrival_datetime"
                   name="arrival_datetime"
                   class="form-control @error('arrival_datetime') is-invalid @enderror"
                   value="{{ old('arrival_datetime', optional(optional($schedule)->arrival_datetime)->format('Y-m-d\TH:i')) }}"
                   required>
            @error('arrival_datetime') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Ticket Upload --}}
          <div class="col-md-6">
            <label for="ticket" class="form-label">
              Upload Ticket (PDF/JPG/PNG) {!! $isEdit ? '' : '<span class="text-danger">*</span>' !!}
            </label>
            <input type="file"
                   id="ticket"
                   name="ticket"
                   class="form-control @error('ticket') is-invalid @enderror"
                   accept=".pdf,image/jpeg,image/jpg,image/png"
                   {{ $isEdit ? '' : 'required' }}>
            @error('ticket') <div class="invalid-feedback">{{ $message }}</div>@enderror
            @if($isEdit && $schedule->ticket_path)
              <small class="form-text text-light">
                Current: {{ basename($schedule->ticket_path) }}
              </small>
            @endif
          </div>

          {{-- Sponsorship Letter --}}
          <div class="col-md-6">
            <label for="sponsorship_letter" class="form-label">
              Sponsorship Letter (PDF) {!! $isEdit ? '' : '<span class="text-danger">*</span>' !!}
            </label>
            <input type="file"
                   id="sponsorship_letter"
                   name="sponsorship_letter"
                   class="form-control @error('sponsorship_letter') is-invalid @enderror"
                   accept=".pdf"
                   {{ $isEdit ? '' : 'required' }}>
            @error('sponsorship_letter') <div class="invalid-feedback">{{ $message }}</div>@enderror
            @if($isEdit && $schedule->sponsorship_letter_path)
              <small class="form-text text-light">
                Current: {{ basename($schedule->sponsorship_letter_path) }}
              </small>
            @endif
          </div>

          {{-- Travel Status --}}
        <div class="col-12">
  <label for="travel_status" class="form-label">
    Travel Status <span class="text-danger">*</span>
  </label>
  <select id="travel_status"
          name="travel_status"
          class="form-select @error('travel_status') is-invalid @enderror"
          required>
    <option disabled value="">Select Status</option>
    <option value="scheduled"
      {{ old('travel_status', $schedule->travel_status ?? '') === 'scheduled' ? 'selected' : '' }}>
      Scheduled
    </option>
    <option value="departed"
      {{ old('travel_status', $schedule->travel_status ?? '') === 'departed' ? 'selected' : '' }}>
      Departed
    </option>
    <option value="arrived"
      {{ old('travel_status', $schedule->travel_status ?? '') === 'arrived' ? 'selected' : '' }}>
      Arrived
    </option>
    <option value="cancelled"
      {{ old('travel_status', $schedule->travel_status ?? '') === 'cancelled' ? 'selected' : '' }}>
      Cancelled
    </option>
    <option value="rescheduled"
      {{ old('travel_status', $schedule->travel_status ?? '') === 'rescheduled' ? 'selected' : '' }}>
      Rescheduled
    </option>
  </select>
  @error('travel_status')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

        </div>

        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-check2-circle me-1"></i>
            {{ $isEdit ? 'Update Schedule' : 'Confirm Schedule' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
  }
</style>
@endsection
