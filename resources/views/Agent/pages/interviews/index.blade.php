{{-- resources/views/agent/interviews/index.blade.php --}}
@extends('agent.layouts.app')

@section('title', 'My Interviews')

@push('css/links')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card-header bg-primary bg-gradient text-white text-center py-3 rounded-top-2">
        <div class="d-flex align-items-center ms-3">
            <i class="bi bi-journal-check me-2"></i>
            <h5 class="mb-0">My Assigned Interviews</h5>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            @php $current = request('status'); @endphp

            {{-- Tabs --}}
            <ul class="nav nav-tabs px-3 pt-3" role="tablist">
                @foreach([
                  'upcoming'  => 'Upcoming',
                  'past'      => 'Past',
                  'postponed' => 'Postponed',
                  'pass'      => 'Pass',
                  'fail'      => 'Fail',
                ] as $key => $label)
                    <li class="nav-item">
                        <a
                          class="nav-link {{ $current === $key || (is_null($current) && $key === 'upcoming') ? 'active' : '' }}"
                          href="{{ route('agent.interviews.index', ['status' => $key]) }}"
                        >{{ $label }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content p-3">
                @foreach(['upcoming','past','postponed','pass','fail'] as $tab)
                    <div
                      class="tab-pane fade {{ $current === $tab || (is_null($current) && $tab === 'upcoming') ? 'show active' : '' }}"
                      id="{{ $tab }}"
                    >
                        <div class="table-responsive">
                            <table id="userstable" class="table table-bordered text-center mb-0">
                               <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Job</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($interviews[$tab] as $data)
                                        @php
                                            $iv = $data['model'];
                                            $isPendingPast = $tab === 'past' && now()->gt($data['end']) && $iv->status === 'pending';
                                            $showActions = in_array($tab, ['upcoming','postponed']) || $isPendingPast;
                                        @endphp
                                        <tr data-iv-id="{{ $iv->id }}" data-meeting-link="{{ $iv->meeting_link }}">
                                            <td>{{ $iv->application->full_name }}</td>
                                            <td>
                                                {{ $data['label'] }}<br>
                                                <small>{{ $iv->interview_date->format('d M Y') }}</small>
                                            </td>
                                            <td>{{ $data['startFmt'] }} – {{ $data['endFmt'] }}</td>
                                            <td>{{ $iv->application->job->title }}</td>
                                            <td>
                                                <span class="badge iv-progress {{ $data['progressBadge'] }}">
                                                    {{ $data['progress'] }}
                                                </span>
                                                @if($tab === 'upcoming' && now()->between($data['start'], $data['end']))
                                                    <a href="{{ $iv->meeting_link }}" target="_blank"
                                                       class="btn btn-sm btn-success ms-1 join-btn">
                                                        <i class="bi bi-camera-video-fill"></i> Join
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($isPendingPast)
                                                    <form action="{{ route('agent.interviews.updateStatus', $iv->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="btn btn-sm btn-success">Pass</button>
                                                    </form>
                                                    <button class="btn btn-sm btn-danger ms-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#failModal"
                                                            data-iv-id="{{ $iv->id }}">
                                                        Fail
                                                    </button>
                                                @else
                                                    <span class="badge status-badge {{ $data['statusBadge'] }}">
                                                        {{ ucfirst($iv->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($showActions)
                                                    <a href="{{ route('agent.interviews.edit', $iv->id) }}"
                                                       class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('agent.interviews.destroy', $iv->id) }}"
                                                          method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-white">No interviews.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Fail Remarks Modal --}}
    <div class="modal fade" id="failModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form id="failForm" method="POST" action="">
          @csrf
          @method('PATCH')
          <input type="hidden" name="status" value="rejected">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Remarks for Fail</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="failRemarks" class="form-label">Remarks</label>
                <textarea name="remarks" id="failRemarks" class="form-control" rows="4" required></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Submit Fail</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    (function() {
      const csrf = document.querySelector('meta[name="csrf-token"]').content;
      const tabs = {
        upcoming:  document.querySelector('#upcoming tbody'),
        past:      document.querySelector('#past tbody'),
        postponed: document.querySelector('#postponed tbody'),
        pass:      document.querySelector('#pass tbody'),
        fail:      document.querySelector('#fail tbody'),
      };

      const rows = Array.from(document.querySelectorAll('tr[data-iv-id]'))
        .reduce((acc, tr) => {
          acc[tr.dataset.ivId] = {
            tr,
            url: `/agent/interviews/${tr.dataset.ivId}/status`
          };
          return acc;
        }, {});

      function capitalize(s) {
        return s.charAt(0).toUpperCase() + s.slice(1);
      }

      function refresh() {
        Object.values(tabs).forEach(tbody => {
          const stale = tbody.querySelector('tr.empty-row');
          if (stale) stale.remove();
        });

        Object.entries(rows).forEach(([id, {tr, url}]) => {
          axios.get(url).then(({data}) => {
            // update badges
            const prog = tr.querySelector('.iv-progress');
            prog.textContent = data.progress;
            prog.className = 'badge iv-progress ' + data.progressBadge;

            // update status cell
            const statusCell = tr.cells[5];
            if (data.progress === 'Ended' && data.status === 'pending') {
              statusCell.innerHTML = `
                <form action="/agent/interviews/${id}/status" method="POST" class="d-inline">
                  <input type="hidden" name="_token" value="${csrf}">
                  <input type="hidden" name="_method" value="PATCH">
                  <input type="hidden" name="status" value="accepted">
                  <button type="submit" class="btn btn-sm btn-success">Pass</button>
                </form>
                <button class="btn btn-sm btn-danger ms-1"
                        data-bs-toggle="modal"
                        data-bs-target="#failModal"
                        data-iv-id="${id}">
                  Fail
                </button>`;
            } else {
              statusCell.innerHTML = `
                <span class="badge status-badge ${data.statusBadge}">
                  ${capitalize(data.status)}
                </span>`;
            }

            // join button logic
            let joinBtn = tr.querySelector('.join-btn');
            if (data.progress === 'In Progress') {
              if (!joinBtn) {
                joinBtn = document.createElement('a');
                joinBtn.className = 'btn btn-sm btn-success ms-1 join-btn';
                joinBtn.href = tr.dataset.meetingLink;
                joinBtn.target = '_blank';
                joinBtn.innerHTML = '<i class="bi bi-camera-video-fill"></i> Join';
                tr.cells[4].appendChild(joinBtn);
              }
            } else if (joinBtn) {
              joinBtn.remove();
            }

            // move to correct tab
            let target = 'upcoming';
            if (data.status === 'pass')           target = 'pass';
            else if (data.status === 'fail')      target = 'fail';
            else if (data.status === 'postponed') target = 'postponed';
            else if (data.progress === 'Ended')   target = 'past';

            if (tr.closest('tbody') !== tabs[target]) {
              tabs[target].appendChild(tr);
            }
          });
        });
      }

      refresh();
      setInterval(refresh, 15000);

      // set modal form action
      document.getElementById('failModal')
        .addEventListener('show.bs.modal', e => {
          const id = e.relatedTarget.getAttribute('data-iv-id');
          document.getElementById('failForm').action = `/agent/interviews/${id}/status`;
        });
    })();
    </script>




 
  <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
  <script>
    $(function() {
      $('#upcomingTable, #pastTable, #postponedTable, #passTable, #failTable').DataTable({
        dom:
          '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>' +
          '<"table-responsive"tr>' +
          '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        renderer: 'bootstrap'
      });
    });
  </script>


 <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#userstable').DataTable();
        });
    </script>
 

@endpush
