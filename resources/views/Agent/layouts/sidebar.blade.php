<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center">
      <img src="{{ asset('assets/images/logo-icon4.png') }}" class="logo-img img-fluid me-2" alt="Logo" / style=" width: 150px; height:100%; margin-top:10px;">
      {{-- <h5 class="mb-0">GlobeHire</h5> --}}
    </div>
    <button class="sidebar-close btn btn-sm btn-light">
      <span class="material-icons-outlined">close</span>
    </button>
  </div>

  <nav class="sidebar-nav">
    <ul class="metismenu list-unstyled" id="sidenav">

      {{-- Dashboard --}}
      <li class="nav-item">
        <a href="{{ route('agent.dashboard') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('agent.dashboard') ? 'active bg-primary text-white' : '' }}">
          <i class="material-icons-outlined">space_dashboard</i>
          <span class="menu-title ms-2">Agent Dashboard</span>
        </a>
      </li>

      {{-- Applications --}}
      <li class="nav-item">
        <a href="{{ route('agent.applications.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('agent.applications.*') ? 'active bg-primary text-white' : '' }}">
          <i class="material-icons-outlined">task_alt</i>
          <span class="menu-title ms-2">Assigned Applications</span>
        </a>
      </li>

      {{-- Interviews Label --}}
      <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center disabled text-warning">
          <i class="material-icons-outlined">record_voice_over</i>
          <span class="menu-title ms-2">Interviews</span>
        </a>
      </li>
      @foreach([
        'upcoming'   => ['icon' => 'calendar_month', 'label' => 'Upcoming'],
        'past'       => ['icon' => 'history',        'label' => 'Past'],
        'postponded' => ['icon' => 'event_note',     'label' => 'Postponed'],
        'pass'       => ['icon' => 'check_circle',   'label' => 'Pass'],
        'fail'       => ['icon' => 'highlight_off',  'label' => 'Fail'],
      ] as $key => $info)
        <li class="nav-item">
          <a href="{{ route('agent.interviews.index', ['status' => $key]) }}"
             class="nav-link d-flex align-items-center {{ request()->routeIs('agent.interviews.index') && request()->get('status') === $key ? 'active bg-primary text-white' : '' }}">
            <i class="material-icons-outlined">{{ $info['icon'] }}</i>
            <span class="menu-title ms-2">{{ $info['label'] }}</span>
          </a>
        </li>
      @endforeach

      {{-- Visa Section --}}
      <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center disabled text-warning">
          <i class="material-icons-outlined">fact_check</i>
          <span class="menu-title ms-2">Visa</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('agent.visa.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('agent.visa.index') ? 'active bg-primary text-white' : '' }}">
          <i class="material-icons-outlined">fact_check</i>
          <span class="menu-title ms-2">Review Documents</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('agent.visa.approved') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('agent.visa.approved') ? 'active bg-primary text-white' : '' }}">
          <i class="material-icons-outlined">verified_user</i>
          <span class="menu-title ms-2">Approved Candidates</span>
        </a>
      </li>

      {{-- Flight Section --}}
      <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center disabled text-warning">
          <i class="material-icons-outlined">flight</i>
          <span class="menu-title ms-2">Flight Schedules</span>
        </a>
      </li>
      @foreach([
        'scheduled'   => ['icon' => 'flight_takeoff', 'label' => 'Scheduled'],
        'departed'    => ['icon' => 'airplane_ticket','label' => 'Departed'],
        'arrived'     => ['icon' => 'flight_land',    'label' => 'Arrived'],
        'cancelled'   => ['icon' => 'cancel',         'label' => 'Cancelled'],
        'rescheduled' => ['icon' => 'update',         'label' => 'Rescheduled'],
      ] as $key => $info)
        <li class="nav-item">
          <a href="{{ route('agent.visa.schedules', ['status' => $key]) }}"
             class="nav-link d-flex align-items-center {{ request()->routeIs('agent.visa.schedules') && request()->get('status') === $key ? 'active bg-primary text-white' : '' }}">
            <i class="material-icons-outlined">{{ $info['icon'] }}</i>
            <span class="menu-title ms-2">{{ $info['label'] }}</span>
          </a>
        </li>
      @endforeach
      <li class="nav-item">
        <a href="{{ route('agent.visa.flight.create', ['visa' => optional(request()->route('visa'))->id ?? 0]) }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('agent.visa.flight.create') ? 'active bg-primary text-white' : '' }}">
          <i class="material-icons-outlined">add_circle_outline</i>
          <span class="menu-title ms-2">New Flight</span>
        </a>
      </li>

      {{-- Support --}}
      <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center">
          <i class="material-icons-outlined">support_agent</i>
          <span class="menu-title ms-2">Support</span>
        </a>
      </li>

    </ul>
  </nav>
</aside>
