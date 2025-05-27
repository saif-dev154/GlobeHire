@extends('employer.layouts.app')

@section('title', 'Passed Interviews')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-journal-check me-2"></i>
                    Passed Interviews
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered text-center mb-0">
                    <thead class="table-light">
                        <tr>
                         <th>#</th>
                            <th>Candidate</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Job Title</th>
                            <th>Application Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($passed as $iv)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $iv->application->full_name }}</td>
                                <td>{{ $iv->interview_date->format('d M Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($iv->start_time)->format('g:i A') }}
                                    –
                                    {{ \Carbon\Carbon::parse($iv->end_time)->format('g:i A') }}
                                </td>
                                <td>{{ $iv->application->job->title }}</td>
                                <td>{{ ucfirst($iv->application->status) }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    {{-- Shortlist --}}
                                    <form action="{{ route('employer.interviews.shortlist', $iv->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-person-check-fill me-1"></i> Shortlist
                                        </button>
                                    </form>
                                    {{-- Reject (opens modal) --}}
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal"
                                        data-url="{{ route('employer.interviews.reject', $iv->id) }}"
                                        data-remarks="{{ old('remarks', '') }}">
                                        <i class="bi bi-x-circle-fill me-1"></i> Reject
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">No passed interviews found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Reject Remarks Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="rejectForm" method="POST" action="" class="modal-content">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Reject Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectRemarks" class="form-label">Remarks <small
                                class="text-muted">(required)</small></label>
                        <textarea name="remarks" id="rejectRemarks" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        @push('scripts')
            <script>
                const rejectModal = document.getElementById('rejectModal');
                rejectModal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget;
                    const url = button.getAttribute('data-url');
                    const remarks = button.getAttribute('data-remarks') || '';
                    const form = document.getElementById('rejectForm');
                    const textarea = document.getElementById('rejectRemarks');

                    form.action = url;
                    textarea.value = remarks;
                });
            </script>
        @endpush
    @endpush
@endsection
