@extends('agent.layouts.app')

@section('title')
   Assigned Visa Reviews
@endsection

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <div class="d-flex align-items-center ms-3">
                    <i class="bi bi-clipboard-data-fill me-2"></i>
                    <h5 class="mb-0">Assigned Visa Reviews</h5>
                </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="userstable" class="table  table-striped table-bordered" style="width:100%">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="py-3 border-0">Candidate</th>
                                    <th class="py-3 border-0">Contract #</th>
                                    <th class="py-3 border-0">Interview Date</th>
                                    <th class="py-3 border-0">Submitted At</th>
                                    <th class="py-3 border-0">Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visas as $visa)
                                    <tr class="text-center align-middle">
                                        <td>
                                            <i class="bi bi-person-circle text-primary me-1"></i>
                                            {{ $visa->contract->interview->application->candidate->name }}
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $visa->contract_id }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ optional($visa->contract->interview->interview_date)->format('d M Y') }}
                                        </td>
                                        <td>
                                            {{ $visa->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.visa.show', $visa) }}"
                                               class="btn btn-sm btn-primary"
                                               data-bs-toggle="tooltip"
                                               title="Review">
                                                <i class="bi bi-eye-fill me-1"></i>Review
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#userstable').DataTable();
        });
    </script>
@endpush
