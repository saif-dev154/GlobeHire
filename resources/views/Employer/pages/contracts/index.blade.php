@extends('employer.layouts.app')

@section('title', 'Manage Contracts')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">
        <i class="bi bi-file-earmark-text-fill me-2"></i> Contracts
      </h5>
    </div>
    <div class="card-body p-0">
@php
  // $status comes from controller
  $status = $status ?? 'created'; // fallback
  $tabs = [
    'created'  => 'Created',
    'signed'   => 'Signed',
    'approved' => 'Approved',
    'rejected' => 'Rejected',
  ];
@endphp

      {{-- Tabs --}}
      <ul class="nav nav-tabs px-3 pt-3" id="contractTabs" role="tablist">
        @foreach($tabs as $key => $label)
          <li class="nav-item" role="presentation">
            <button class="nav-link {{ $status === $key ? 'active' : '' }}"
                    id="{{ $key }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#{{ $key }}"
                    type="button"
                    role="tab"
                    aria-controls="{{ $key }}"
                    aria-selected="{{ $status === $key ? 'true' : 'false' }}">
              {{ $label }}
            </button>
          </li>
        @endforeach
      </ul>

      <div class="tab-content p-3" id="contractTabsContent">

        {{-- Created Tab --}}
        <div class="tab-pane fade {{ $status === 'created' ? 'show active' : '' }}" id="created" role="tabpanel">
          <table class="table mb-0">
            <thead class="bg-primary text-center text-white">
              <tr>
                <th>Candidate</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($createdContracts as $contract)
                <tr class="text-center align-middle">
                  <td>{{ $contract->interview->application->full_name }}</td>
                  <td>{{ $contract->contract_date->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('employer.contracts.show', $contract->id) }}" class="btn btn-sm btn-info me-1">View</a>
                    <a href="{{ route('employer.contracts.edit', $contract->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                    <form action="{{ route('employer.contracts.destroy', $contract->id) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contract?')">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-center">No created contracts.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Signed Tab --}}
        <div class="tab-pane fade {{ $status === 'signed' ? 'show active' : '' }}" id="signed" role="tabpanel">
          <table class="table mb-0">
            <thead class="bg-primary text-center text-white">
              <tr>
                <th>Candidate</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($signedContracts as $contract)
                <tr class="text-center align-middle">
                  <td>{{ $contract->interview->application->full_name }}</td>
                  <td>{{ $contract->contract_date->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('employer.contracts.showSignature', $contract->id) }}" class="btn btn-sm btn-primary me-1">View Signature</a>
                    <form action="{{ route('employer.contracts.approve', $contract->id) }}" method="POST" class="d-inline me-1">
                      @csrf
                      <button class="btn btn-sm btn-success">Approve</button>
                    </form>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $contract->id }}">
                      Reject
                    </button>

                    {{-- Modal --}}
                    <div class="modal fade" id="rejectModal-{{ $contract->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{ route('employer.contracts.reject', $contract->id) }}" method="POST">
                          @csrf
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Reject Contract</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="remarks-{{ $contract->id }}" class="form-label">Remarks</label>
                                <textarea name="remarks" id="remarks-{{ $contract->id }}" class="form-control" rows="3" required></textarea>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-danger">Submit Rejection</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-center">No signed contracts.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Approved Tab --}}
        <div class="tab-pane fade {{ $status === 'approved' ? 'show active' : '' }}" id="approved" role="tabpanel">
          <table class="table mb-0">
            <thead class="bg-primary text-center text-white">
              <tr>
                <th>Candidate</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($approvedContracts as $contract)
                <tr class="text-center align-middle">
                  <td>{{ $contract->interview->application->full_name }}</td>
                  <td>{{ $contract->contract_date->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('employer.contracts.showSignature', $contract->id) }}" class="btn btn-sm btn-primary">View</a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-center">No approved contracts.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>








        {{-- Rejected Tab --}}
        <div class="tab-pane fade {{ $status === 'rejected' ? 'show active' : '' }}" id="rejected" role="tabpanel">
          <table class="table mb-0">
            <thead class="bg-primary text-center text-white">
              <tr>
                <th>Candidate</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($rejectedContracts as $contract)
                <tr class="text-center align-middle">
                  <td>{{ $contract->interview->application->full_name }}</td>
                  <td>{{ $contract->contract_date->format('d M Y') }}</td>
                  <td>{{ $contract->status }}</td>

                </tr>
              @empty
                <tr><td colspan="3" class="text-center">No Rejected contracts.</td></tr>
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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const status = @json($status);
    const tabTrigger = document.querySelector(`#${status}-tab`);
    if (tabTrigger) {
      new bootstrap.Tab(tabTrigger).show();
    }
  });
</script>
@endpush
