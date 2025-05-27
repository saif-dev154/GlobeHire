@extends('candidate.layouts.app')

@section('title')
    My Contracts
@endsection

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
          <div class="d-flex align-items-center ms-3">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>
                    <h5 class="mb-0">My Contracts</h5>
                </div>       

    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="contracttable" class="table  table-striped table-bordered" style="width:100%">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="py-3 border-0">Contract ID</th>
                                    <th class="py-3 border-0">Contract Date</th>
                                    <th class="py-3 border-0">Status</th>
                                    <th class="py-3 border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contracts as $contract)
                                    <tr class="text-center align-middle">
                                        <td>{{ $contract->id }}</td>
                                        <td>{{ $contract->contract_date->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="badge
                                                {{ $contract->status === 'created'
                                                    ? 'bg-warning'
                                                    : ($contract->status === 'signed'
                                                        ? 'bg-primary'
                                                        : ($contract->status === 'approved'
                                                            ? 'bg-success'
                                                            : 'bg-danger')) }}">
                                                {{ ucfirst($contract->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($contract->status === 'created')
                                                <a href="{{ route('candidate.contracts.sign', $contract->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-pencil-square me-1"></i>Sign Now
                                                </a>
                                            @elseif ($contract->status === 'signed')
                                                <a href="{{ route('candidate.contracts.sign', $contract->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye-fill me-1"></i>View Signature
                                                </a>
                                            @elseif ($contract->status === 'approved')
                                                <!-- Here we pass $contract->id -->
                                                <a href="{{ route('candidate.visa.create', $contract->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-clipboard-check me-1"></i>Apply Visa
                                                </a>
                                            @elseif ($contract->status === 'rejected')
                                                <span class="text-muted">Rejected</span>
                                            @else
                                                <span>Unknown status</span>
                                            @endif
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
            $('#contracttable').DataTable();
        });
    </script>
@endpush
