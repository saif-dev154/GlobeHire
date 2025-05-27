{{-- resources/views/agent/pages/AssignedApplications/show.blade.php --}}
@extends('agent.layouts.app')

@section('title', 'Application Review')

@section('content')
    @php
        // Decode required_skills safely into an array
        $reqSkills = is_string($app->job->required_skills)
            ? json_decode($app->job->required_skills, true) ?? []
            : $app->job->required_skills;
    @endphp

    <div class="container py-4">
        <div class="card shadow-sm rounded-2 border-0">

            {{-- Header --}}
            <div class="card-header bg-primary bg-gradient text-white py-2 px-3">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-folder-fill me-1"></i> Application #{{ $app->id }}
                    </h5>
                    <small class="opacity-75">
                        Applied on {{ $app->created_at->format('d M Y, h:i A') }}
                    </small>
                </div>
            </div>

            <div class="card-body p-4">
                {{-- Job & Candidate --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-1">Job Applied</h6>
                        <p class="mb-0"><strong>{{ $app->job->title }}</strong></p>
                        <p class="text-white">{{ $app->job->location }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-1">Candidate</h6>
                        <p class="mb-0">{{ $app->full_name }}</p>
                        <p class="text-white">{{ $app->email }}</p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <h6 class="fw-semibold mb-1">Current Status</h6>
                    <span
                        class="badge
          {{ $app->status === 'pending' ? 'bg-secondary' : ($app->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                        {{ ucfirst($app->status) }}
                    </span>
                </div>

                {{-- Personal & Contact --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Personal Details</h6>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Name:</strong> {{ $app->full_name }}</li>
                            <li><strong>DOB:</strong> {{ $app->date_of_birth->format('d M Y') }}</li>
                            <li><strong>Gender:</strong> {{ ucfirst($app->gender) }}</li>
                            <li><strong>Nationality:</strong> {{ $app->nationality }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Contact Details</h6>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Email:</strong> {{ $app->email }}</li>
                            <li><strong>Phone:</strong> {{ $app->phone }}</li>
                            <li><strong>Address:</strong> {{ $app->address }}</li>
                            <li><strong>Country:</strong> {{ $app->country }}</li>
                        </ul>
                    </div>
                </div>

                {{-- Education & Experience --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Education</h6>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Degree:</strong> {{ ucfirst(str_replace('_', ' ', $app->highest_degree)) }}</li>
                            <li><strong>Institution:</strong> {{ $app->institution }}</li>
                            <li><strong>Field:</strong> {{ $app->field_of_study }}</li>
                            <li><strong>Graduation:</strong> {{ optional($app->graduation_date)->format('d M Y') ?? '—' }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-2">Experience</h6>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Years:</strong> {{ $app->years_experience }}</li>
                            <li><strong>Last Employer:</strong> {{ $app->last_employer ?? '—' }}</li>
                            <li><strong>Position:</strong> {{ $app->last_position ?? '—' }}</li>
                            <li><strong>Duration:</strong> {{ $app->employment_duration ?? '—' }}</li>
                        </ul>
                    </div>
                </div>

                {{-- Skills --}}
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Skills</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($reqSkills as $skill)
                            <span class="badge {{ in_array($skill, $app->skills) ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($skill) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Cover & Attachments --}}
                {{-- Cover & Attachments --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-1">Cover Letter</h6>
                        <p class="border p-2">{{ $app->cover_letter ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-1">Attachments</h6>
                        <ul class="mb-0 list-unstyled">
                            {{-- Resume --}}
                            @if ($app->resume_path)
                                <li>
                                    <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank">
                                        <i class="bi bi-file-earmark-text me-1"></i> Resume
                                    </a>
                                </li>
                            @endif

                            {{-- Other Documents --}}
                            @if (is_array($app->other_docs_paths) && count($app->other_docs_paths))
                                @foreach ($app->other_docs_paths as $index => $path)
                                    <li>
                                        <a href="{{ Storage::disk('public')->url($path) }}" target="_blank">
                                            <i class="bi bi-paperclip me-1"></i> Attachment {{ $index + 1 }}
                                            ({{ basename($path) }})
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-muted">No other documents uploaded.</li>
                            @endif
                        </ul>
                    </div>
                </div>


                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Left: Back Button --}}
                    <a href="{{ route('agent.applications.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>

                    {{-- Right: Approve & Reject Buttons --}}
                    <div class="d-flex gap-2">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="bi bi-check-circle me-1"></i> Approve & Schedule
                        </button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-1"></i> Reject
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Approve & Schedule Interview Modal --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('agent.applications.interview.store', $app->id) }}" method="POST"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Schedule Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="interview_date" class="form-label">Interview Date</label>
                        <input type="date" id="interview_date" name="interview_date" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="meeting_link" class="form-label">Meeting Link</label>
                        <input type="url" id="meeting_link" name="meeting_link" class="form-control"
                            placeholder="https://..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reject Application Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('agent.applications.reject', $app->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Remarks</label>
                        <textarea id="rejection_reason" name="remarks" rows="4" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
