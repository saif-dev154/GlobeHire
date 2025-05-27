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
      <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" 
           class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
          <i class="material-icons-outlined me-2">dashboard</i>
          <span class="menu-title">Admin Dashboard</span>
        </a>
      </li>

      {{-- User Management Section --}}
      <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center disabled text-warning">
          <i class="material-icons-outlined">manage_accounts</i>
          <span class="menu-title ms-2">User Management</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('admin.users.create') ? 'mm-active' : '' }}">
        <a href="{{ route('admin.users.create') }}" 
           class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.create') ? 'bg-primary text-white' : '' }}">
          <i class="material-icons-outlined me-2">person_add</i>
          <span class="menu-title">Create User</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('admin.users.index') ? 'mm-active' : '' }}">
        <a href="{{ route('admin.users.index') }}" 
           class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.index') ? 'bg-primary text-white' : '' }}">
          <i class="material-icons-outlined me-2">people</i>
          <span class="menu-title">Candidate List</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('admin.users.agents.index') ? 'mm-active' : '' }}">
        <a href="{{ route('admin.users.agents.index') }}" 
           class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.agents.index') ? 'bg-primary text-white' : '' }}">
          <i class="material-icons-outlined me-2">support_agent</i>
          <span class="menu-title">Agent List</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('admin.users.employers.index') ? 'mm-active' : '' }}">
        <a href="{{ route('admin.users.employers.index') }}" 
           class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.employers.index') ? 'bg-primary text-white' : '' }}">
          <i class="material-icons-outlined me-2">business_center</i>
          <span class="menu-title">Employer List</span>
        </a>
      </li>

      {{-- Support Section --}}
      <li class="nav-item px-3 mt-4 text-warning small text-uppercase">Help & Support</li>
      <li class="nav-item">
        <a href="javascript:;" class="nav-link d-flex align-items-center">
          <i class="material-icons-outlined me-2">support_agent</i>
          <span class="menu-title">Support</span>
        </a>
      </li>

    </ul>
  </nav>
</aside>
