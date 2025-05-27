{{-- resources/views/candidate/interviews/index.blade.php --}}
@extends('candidate.layouts.app')

@section('title', 'My Interviews')

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <div class="d-flex align-items-center ms-3">
            <i class="bi bi-people me-2"></i>
            <h5 class="mb-0">My Scheduled Interviews</h5>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            {{-- Tabs --}}
            <ul class="nav nav-tabs px-3 pt-3" id="interviewTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
                            type="button" role="tab">Upcoming</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past"
                            type="button" role="tab">Past</button>
                </li>
            </ul>

            <div class="tab-content p-3" id="interviewTabsContent">
                {{-- Upcoming Interviews --}}
                <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                    <div class="table-responsive">
                        <table id="upcomingTable" class="table table-striped table-bordered text-center align-middle mb-0" style="width:100%">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="py-3 border-0">Candidate</th>
                                    <th class="py-3 border-0">Date</th>
                                    <th class="py-3 border-0">Time</th>
                                    <th class="py-3 border-0">Job</th>
                                    <th class="py-3 border-0">Status</th>
                                    <th class="py-3 border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingInterviews as $iv)
                                    <tr class="text-center align-middle">
                                        <td>{{ $iv->candidate_name }}</td>
                                        <td>
                                            {{ $iv->date_label }}<br>
                                            <small>{{ $iv->date_formatted }}</small>
                                        </td>
                                        <td>{{ $iv->start_time }} – {{ $iv->end_time }}</td>
                                        <td>{{ $iv->job_title }}</td>
                                        <td>
                                            <span class="badge {{ $iv->status_badge }}">{{ $iv->status_text }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('candidate.interviews.show', $iv->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-eye-fill me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No upcoming interviews.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Past Interviews --}}
                <div class="tab-pane fade" id="past" role="tabpanel">
                    <div class="table-responsive">
                        <table id="pastTable" class="table table-striped table-bordered text-center align-middle mb-0" style="width:100%">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="py-3 border-0">Candidate</th>
                                    <th class="py-3 border-0">Date</th>
                                    <th class="py-3 border-0">Time</th>
                                    <th class="py-3 border-0">Job</th>
                                    <th class="py-3 border-0">Status</th>
                                    <th class="py-3 border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pastInterviews as $iv)
                                    <tr class="text-center align-middle">
                                        <td>{{ $iv->candidate_name }}</td>
                                        <td>
                                            {{ $iv->date_label }}<br>
                                            <small>{{ $iv->date_formatted }}</small>
                                        </td>
                                        <td>{{ $iv->start_time }} – {{ $iv->end_time }}</td>
                                        <td>{{ $iv->job_title }}</td>
                                        <td>
                                            <span class="badge {{ $iv->status_badge }}">{{ $iv->status_text }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('candidate.interviews.show', $iv->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-eye-fill me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No past interviews.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#upcomingTable').DataTable();
            $('#pastTable').DataTable();
        });
    </script>
@endpush
