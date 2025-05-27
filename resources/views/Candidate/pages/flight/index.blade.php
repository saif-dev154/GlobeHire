{{-- resources/views/candidate/visa/flights/index.blade.php --}}
@extends('candidate.layouts.app')

@section('title')
    My Flight Schedules
@endsection

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <div class="d-flex align-items-center ms-3">
            <i class="bi bi-calendar-week me-2"></i>
            <h5 class="mb-0">My Flight Schedules</h5>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if($schedules->isEmpty())
                <div class="alert alert-info m-3">
                    No flight schedules have been created yet.
                </div>
            @else
                <div class="table-responsive">
                    <table id="scheduletable" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th class="py-3 border-0">Airline</th>
                                <th class="py-3 border-0">Flight #</th>
                                <th class="py-3 border-0">Departure</th>
                                <th class="py-3 border-0">Arrival</th>
                                <th class="py-3 border-0">Status</th>
                                <th class="py-3 border-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $sch)
                                <tr class="text-center align-middle">
                                    <td>{{ $sch->airline }}</td>
                                    <td>{{ $sch->flight_number ?? '–' }}</td>
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
                                            {{ $sch->travel_status === 'completed'                   ? 'bg-success'       : '' }}
                                            {{ $sch->travel_status === 'cancelled'                   ? 'bg-danger'        : '' }}
                                            {{ in_array($sch->travel_status, ['scheduled','ticket_uploaded']) ? 'bg-warning text-dark' : '' }}
                                            {{ $sch->travel_status === 'boarding'                    ? 'bg-info text-white'  : '' }}">
                                            {{ Str::title(str_replace('_', ' ', $sch->travel_status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('candidate.visa.flights.show', ['visa' => $visa->id, 'schedule' => $sch->id]) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye-fill me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#scheduletable').DataTable();
        });
    </script>
@endpush
