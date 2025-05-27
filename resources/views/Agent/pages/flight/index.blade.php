@extends('agent.layouts.app')

@section('title', 'All Flight Schedules')


@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex align-items-center">
      <i class="bi bi-list-columns-reverse me-2"></i>
      <h5 class="mb-0">All Flight Schedules</h5>
    </div>

    <div class="card-body">
      @php
        $activeStatus = request('status', 'scheduled');
        $statuses     = ['scheduled','departed','arrived','cancelled','rescheduled'];
      @endphp

      <ul class="nav nav-tabs mb-3" role="tablist">
        @foreach($statuses as $status)
          <li class="nav-item" role="presentation">
            <button
              class="nav-link {{ $activeStatus === $status ? 'active' : '' }}"
              id="{{ $status }}-tab"
              data-bs-toggle="tab"
              data-bs-target="#{{ $status }}"
              type="button"
              role="tab"
            >
              {{ ucfirst($status) }}
            </button>
          </li>
        @endforeach
      </ul>

      <div class="tab-content">
        @foreach($statuses as $status)
          <div
            class="tab-pane fade {{ $activeStatus === $status ? 'show active' : '' }}"
            id="{{ $status }}"
            role="tabpanel"
          >
            @php $items = $schedules->where('travel_status', $status); @endphp

            @if($items->isEmpty())
              <div class="alert alert-info">No {{ ucfirst($status) }} schedules.</div>
            @else
              <div class="table-responsive">
                <table id="userstable" class="table table-hover text-center align-middle mb-0">
                  <thead class="table bg-primary">
                    <tr>
                      <th>Candidate</th>
                      <th>Contract #</th>
                      <th>Departure</th>
                      <th>Arrival</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $sch)
                      <tr>
                        <td>{{ $sch->visaDocument->contract->interview->application->candidate->name }}</td>
                        <td>#{{ $sch->visaDocument->contract_id }}</td>
                        <td>
                          {{ $sch->departure_datetime->format('d M, Y H:i') }}<br>
                          <small>{{ $sch->departure_airport }}</small>
                        </td>
                        <td>
                          {{ $sch->arrival_datetime->format('d M, Y H:i') }}<br>
                          <small>{{ $sch->arrival_airport }}</small>
                        </td>
                        <td>
                          <span class="badge 
                            {{ $status === 'arrived'     ? 'bg-success' : '' }}
                            {{ $status === 'cancelled'   ? 'bg-danger'  : '' }}
                            {{ $status === 'scheduled'   ? 'bg-warning text-dark' : '' }}
                            {{ $status === 'departed'    ? 'bg-info text-white'   : '' }}
                            {{ $status === 'rescheduled' ? 'bg-secondary text-white' : '' }}
                          ">
                            {{ ucfirst($status) }}
                          </span>
                        </td>
                        <td>
                          @if($status === 'scheduled')
                            <a href="{{ route('agent.visa.flight.edit', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                               class="btn btn-sm btn-primary me-1">
                              <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="{{ route('agent.visa.flight.show', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                               class="btn btn-sm btn-info me-1">
                              <i class="bi bi-eye-fill"></i>
                            </a>
                            <form action="{{ route('agent.visa.flight.destroy', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this schedule?');">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash-fill"></i>
                              </button>
                            </form>

                          @elseif(in_array($status, ['departed','arrived']))
                            <a href="{{ route('agent.visa.flight.show', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                               class="btn btn-sm btn-info">
                              <i class="bi bi-eye-fill"></i>
                            </a>

                          @else {{-- cancelled & rescheduled --}}
                            <a href="{{ route('agent.visa.flight.edit', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                               class="btn btn-sm btn-primary me-1">
                              <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="{{ route('agent.visa.flight.show', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                               class="btn btn-sm btn-info me-1">
                              <i class="bi bi-eye-fill"></i>
                            </a>
                            <form action="{{ route('agent.visa.flight.destroy', ['visa'=>$sch->visa_document_id,'schedule'=>$sch->id]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this schedule?');">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash-fill"></i>
                              </button>
                            </form>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        @endforeach
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
            $('#userstable').DataTable();
        });
    </script>
@endpush