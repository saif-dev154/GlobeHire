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
        <a href="{{ route('candidate.dashboard') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.dashboard') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">dashboard</i>
          <span class="menu-title ms-2">Dashboard</span>
        </a>
      </li>

      {{-- Browse Jobs --}}
      <li class="nav-item">
        <a href="{{ route('candidate.jobs.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.jobs.index') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">work</i>
          <span class="menu-title ms-2">Browse Jobs</span>
        </a>
      </li>

      {{-- My Applications --}}
      <li class="nav-item">
        <a href="{{ route('candidate.applications.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.applications.index') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">description</i>
          <span class="menu-title ms-2">My Applications</span>
        </a>
      </li>

      {{-- Interviews --}}
      <li class="nav-item">
        <a href="{{ route('candidate.interviews.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.interviews.*') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">record_voice_over</i>
          <span class="menu-title ms-2">Interviews</span>
        </a>
      </li>

      {{-- Contracts --}}
      <li class="nav-item">
        <a href="{{ route('candidate.contracts.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.contracts.*') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">edit_document</i>
          <span class="menu-title ms-2">Contracts</span>
        </a>
      </li>

      {{-- Visa Documents --}}
      <li class="nav-item">
        <a href="{{ route('candidate.visa.index') }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.visa.*') && !request()->routeIs('candidate.visa.flights.*') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">assignment_turned_in</i>
          <span class="menu-title ms-2">Visa Documents</span>
        </a>
      </li>

      {{-- Flight Schedules --}}
      <li class="nav-item">
    @if($hasVisa && $latestVisa)
        <a href="{{ route('candidate.visa.flights.index', ['visa' => $latestVisa->id]) }}"
           class="nav-link d-flex align-items-center {{ request()->routeIs('candidate.visa.flights.*') ? 'active bg-primary text-white' : '' }}">
          <i class="material-symbols-outlined">flight_takeoff</i>
          <span class="menu-title ms-2">Flight Schedules</span>
        </a>
    @else
        <a href="javascript:void(0)" class="nav-link disabled d-flex align-items-center" tabindex="-1" aria-disabled="true">
          <i class="material-symbols-outlined">flight_takeoff</i>
          <span class="menu-title ms-2">Flight Schedules</span>
        </a>
    @endif
</li>


      {{-- Support --}}
      {{-- <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center">
          <i class="material-symbols-outlined">support_agent</i>
          <span class="menu-title ms-2">Support</span>
        </a>
      </li> --}}

    </ul>
  </nav>
</aside>
