<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
        
        <div class="btn-toggle">
            <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
        </div>

        <div class="search-bar flex-grow-1">
            <div class="position-relative">
                <div class="d-lg-block d-none ms-3 welcome-message bg-light rounded-5 px-4 py-2">
                    <h5 class="mb-0 text-white">
                        Welcome{{ auth()->check() ? ', ' . auth()->user()->name : '' }}
                    </h5>
                </div>
            </div>
        </div>

        <ul class="navbar-nav gap-1 nav-right-links align-items-center">

            <!-- Notifications (unchanged) -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                   data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;">
                    <i class="material-icons-outlined">notifications</i>
                    <span class="badge-notify">5</span>
                </a>

                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                    <div class="px-3 py-1 border-bottom">
                        <h5 class="mb-0">Notifications</h5>
                    </div>

                    <div class="notify-list">
                        <a class="dropdown-item border-bottom py-2" href="javascript:;">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/images/avatars/01.png') }}" 
                                     class="rounded-circle" width="45" height="45" alt="" />
                                <div>
                                    <h5 class="notify-title">Congratulations Jhon</h5>
                                    <p class="mb-0 notify-desc">You have won the gifts.</p>
                                    <p class="mb-0 notify-time">Today</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </li>

            <!-- User Dropdown (ONLY LOGOUT) -->
            <li class="nav-item dropdown">
                <a href="javascript:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/images/avatars/01.png') }}" 
                         class="rounded-circle p-1 border"
                         width="45" height="45" alt="" />
                </a>

                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">

                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                    </form>

                    <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                       href="javascript:void(0);"
                       onclick="document.getElementById('logout-form').submit();">
                        <i class="material-icons-outlined">power_settings_new</i> Logout
                    </a>

                </div>
            </li>

        </ul>
    </nav>
</header>