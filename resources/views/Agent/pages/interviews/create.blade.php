@extends('agent.layouts.app')

@section('title','Edit Interview')

@section('content')
  <div class="container min-vh-100 d-flex flex-column">
    <main class="flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-primary bg-gradient text-light text-center py-3 rounded-top-2">
              <h4 class="mb-0 fw-bold">
                <i class="bi bi-clock-fill me-2"></i>
                Edit Interview
              </h4>
              <small class="text-white fst-italic">
                Update interview details below
              </small>
            </div>
            <div class="card-body p-4">
              <form action="{{ route('agent.interviews.update', $iv->id) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Interview Date --}}
                <div class="mb-3">
                  <label for="interview_date" class="form-label">Interview Date</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                    <input
                      type="date"
                      id="interview_date"
                      name="interview_date"
                      class="form-control @error('interview_date') is-invalid @enderror"
                      value="{{ old('interview_date', $iv->interview_date->format('Y-m-d')) }}"
                      required>
                    @error('interview_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Start & End Time --}}
                <div class="row g-3 mb-3">
                  <div class="col">
                    <label for="start_time" class="form-label">Start Time</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                      <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        class="form-control @error('start_time') is-invalid @enderror"
                        value="{{ old('start_time', \Carbon\Carbon::parse($iv->start_time)->format('H:i')) }}"
                        required>
                      @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col">
                    <label for="end_time" class="form-label">End Time</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                      <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        class="form-control @error('end_time') is-invalid @enderror"
                        value="{{ old('end_time', \Carbon\Carbon::parse($iv->end_time)->format('H:i')) }}"
                        required>
                      @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                {{-- Meeting Link --}}
                <div class="mb-3">
                  <label for="meeting_link" class="form-label">Meeting Link</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                    <input
                      type="url"
                      id="meeting_link"
                      name="meeting_link"
                      class="form-control @error('meeting_link') is-invalid @enderror"
                      placeholder="https://..."
                      value="{{ old('meeting_link', $iv->meeting_link) }}"
                      required>
                    @error('meeting_link')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-gear-fill"></i></span>
                    <select
                      id="status"
                      name="status"
                      class="form-select @error('status') is-invalid @enderror"
                      required>
                      <option disabled value="">Select Status</option>
                      <option value="pending"   {{ old('status', $iv->status==='pending'?'pending':($iv->status==='pass'?'accepted':'postponed'))==='pending' ? 'selected' : '' }}>Pending</option>
                      <option value="accepted"  {{ old('status', $iv->status==='pass'?'accepted':null)==='accepted' ? 'selected' : '' }}>Pass</option>
                      <option value="rejected"  {{ old('status', $iv->status==='fail'?'rejected':null)==='rejected' ? 'selected' : '' }}>Fail</option>
                      <option value="postponed" {{ old('status', $iv->status==='postponed'?'postponed':null)==='postponed' ? 'selected' : '' }}>Postponed</option>
                    </select>
                    @error('status')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Remarks --}}
                <div class="mb-3">
                  <label for="remarks" class="form-label">Remarks</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                    <textarea
                      id="remarks"
                      name="remarks"
                      rows="3"
                      class="form-control @error('remarks') is-invalid @enderror"
                      placeholder="Add remarks if failing…">{{ old('remarks', $iv->remarks) }}</textarea>
                    @error('remarks')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                  <a href="{{ route('agent.interviews.index') }}"
                     class="btn btn-outline-secondary px-4">
                    Cancel
                  </a>
                  <button type="submit" class="btn btn-success px-4">
                    Update
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
@endsection
