@extends('employer.layouts.app')

@section('title', $contract ? 'Edit Contract' : 'Create Contract')

@section('content')
@php
  $interview = $iv ?? $contract?->interview;
@endphp

<div class="container py-3" style="max-width:800px">
  <div class="card shadow-sm border-0 rounded-3">

    <div class="card-header bg-primary text-white text-center py-2">
      <h5 class="mb-0">
        <i class="bi bi-file-earmark-text-fill me-1"></i>
        {{ $contract ? 'Edit Contract' : 'Create Contract' }}
      </h5>
      <small>{{ $contract ? 'Update details below' : 'Fill details below' }}</small>
    </div>

    <div class="card-body p-3">
      @if($contract)
        <form method="POST" action="{{ route('employer.contracts.update', $contract) }}">
          @method('PUT')
      @else
        <form method="POST" action="{{ route('employer.contracts.store') }}">
      @endif
        @csrf

        @unless($contract)
          <input type="hidden" name="interview_id" value="{{ $interview->id }}">
        @endunless

        <div class="row g-3">
          {{-- Candidate --}}
          <div class="col-md-6">
            <label class="small" for="candidate_name">Candidate</label>
            <input type="text" id="candidate_name" class="form-control form-control-sm" 
                   value="{{ $interview->application->full_name ?? '' }}" readonly>
          </div>

          {{-- Job Title --}}
          <div class="col-md-6">
            <label class="small" for="job_title">Job Title</label>
            <input type="text" id="job_title" class="form-control form-control-sm"
                   value="{{ $interview->application->job->title ?? '' }}" readonly>
          </div>

          {{-- Job Location --}}
          <div class="col-md-6">
            <label class="small" for="job_location">Job Location</label>
            <input type="text" id="job_location" class="form-control form-control-sm"
                   value="{{ $interview->application->job->location ?? '' }}" readonly>
          </div>

          {{-- Contract Date --}}
          <div class="col-md-6">
            <label for="contract_date" class="small">Contract Date</label>
            <input type="date" id="contract_date" name="contract_date"
                   class="form-control form-control-sm @error('contract_date') is-invalid @enderror"
                   value="{{ old('contract_date', $contract?->contract_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                   required>
            @error('contract_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Start Date --}}
          <div class="col-md-6">
            <label for="start_date" class="small">Start Date</label>
            <input type="date" id="start_date" name="start_date"
                   class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                   value="{{ old('start_date', $contract?->start_date?->format('Y-m-d')) }}"
                   required>
            @error('start_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Salary --}}
          <div class="col-md-6">
            <label for="salary" class="small">Salary</label>
            <input type="text" id="salary" name="salary"
                   class="form-control form-control-sm @error('salary') is-invalid @enderror"
                   value="{{ old('salary', $contract->salary ?? '') }}" required>
            @error('salary')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Working Hours --}}
          <div class="col-md-6">
            <label for="working_hours" class="small">Working Hours</label>
            <input type="text" id="working_hours" name="working_hours"
                   class="form-control form-control-sm @error('working_hours') is-invalid @enderror"
                   value="{{ old('working_hours', $contract->working_hours ?? '') }}">
            @error('working_hours')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Leave Entitlement --}}
          <div class="col-md-6">
            <label for="leave_entitlement" class="small">Leave Entitlement</label>
            <input type="text" id="leave_entitlement" name="leave_entitlement"
                   class="form-control form-control-sm @error('leave_entitlement') is-invalid @enderror"
                   value="{{ old('leave_entitlement', $contract->leave_entitlement ?? '') }}">
            @error('leave_entitlement')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Notice Period --}}
          <div class="col-md-6">
            <label for="notice_period" class="small">Notice Period</label>
            <input type="text" id="notice_period" name="notice_period"
                   class="form-control form-control-sm @error('notice_period') is-invalid @enderror"
                   value="{{ old('notice_period', $contract->notice_period ?? '') }}">
            @error('notice_period')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Jurisdiction --}}
          <div class="col-md-6">
            <label for="jurisdiction" class="small">Jurisdiction</label>
            <input type="text" id="jurisdiction" name="jurisdiction"
                   class="form-control form-control-sm @error('jurisdiction') is-invalid @enderror"
                   value="{{ old('jurisdiction', $contract->jurisdiction ?? '') }}">
            @error('jurisdiction')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Deadline --}}
          <div class="col-md-6">
            <label for="deadline" class="small">Deadline</label>
            <input type="date" id="deadline" name="deadline"
                   class="form-control form-control-sm @error('deadline') is-invalid @enderror"
                   value="{{ old('deadline', $contract?->deadline?->format('Y-m-d')) }}"
                   required>
            @error('deadline')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Termination Terms --}}
        <div class="col-md-12 mt-3">
          <label for="termination_terms" class="small">Termination Terms</label>
          <textarea id="termination_terms" name="termination_terms" rows="3"
                    class="form-control form-control-sm @error('termination_terms') is-invalid @enderror">{{ old('termination_terms', $contract->termination_terms ?? '') }}</textarea>
          @error('termination_terms')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Contract Body --}}
        <div class="col-md-12 mt-3">
          <label for="body" class="small">Contract Body / Main Terms</label>
          <textarea id="body" name="body" rows="4"
                    class="form-control form-control-sm @error('body') is-invalid @enderror"
                    required>{{ old('body', $contract->body ?? '') }}</textarea>
          @error('body')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('employer.contracts.index') }}" class="btn btn-outline-secondary btn-sm me-2">
            Cancel
          </a>
          <button type="submit" class="btn btn-{{ $contract ? 'primary' : 'success' }} btn-sm">
            <i class="bi bi-{{ $contract ? 'pencil-fill' : 'check-circle-fill' }} me-1"></i>
            {{ $contract ? 'Update Contract' : 'Create Contract' }}
          </button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
