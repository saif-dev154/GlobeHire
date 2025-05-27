{{-- resources/views/candidate/visa/index.blade.php --}}
@extends('candidate.layouts.app')

@section('title')
    My Visa Documents
@endsection

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <div class="d-flex align-items-center ms-3">
            <i class="bi bi-file-earmark-medical-fill me-2"></i>
            <h5 class="mb-0">My Visa Documents</h5>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if($visas->isEmpty())
                <div class="alert alert-info m-3">
                    You have not uploaded any visa documents yet.
                </div>
            @else
                <div class="table-responsive">
                    <table id="visatable" class="table table-striped table-bordered" style="width:100%">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th class="py-3 border-0">Contract #</th>
                                <th class="py-3 border-0">Status</th>
                                <th class="py-3 border-0">Submitted At</th>
                                <th class="py-3 border-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visas as $visa)
                                <tr class="text-center align-middle">
                                    <td>#{{ $visa->contract_id }}</td>
                                    <td>
                                        <span class="badge
                                            {{ $visa->status === 'approved'  ? 'bg-success' : '' }}
                                            {{ $visa->status === 'rejected'  ? 'bg-danger'  : '' }}
                                            {{ $visa->status === 'inreview'  ? 'bg-primary' : '' }}
                                            {{ $visa->status === 'submitted' ? 'bg-warning text-dark' : '' }}">
                                            {{ ucfirst($visa->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $visa->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('candidate.visa.show', $visa) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye-fill me-1"></i>View
                                        </a>
                                        @if(
                                            $visa->status === 'submitted' ||
                                            collect($visa->getAttributes())
                                                ->filter(fn($v, $k) => str_ends_with($k, '_status') && $v === 'rejected')
                                                ->isNotEmpty()
                                        )
                                            <a href="{{ route('candidate.visa.edit', $visa) }}"
                                               class="btn btn-sm btn-primary ms-2">
                                                <i class="bi bi-pencil-fill me-1"></i>Edit
                                            </a>
                                        @endif
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
            $('#visatable').DataTable();
        });
    </script>
@endpush
