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
                <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close"
                    style="display: none;"></span>
                <div class="search-popup p-3">
                    <div class="card rounded-4 overflow-hidden" style="display:none;">
                        <div class="card-header d-lg-none">
                            <div class="position-relative">
                                <input class="form-control rounded-5 px-5 mobile-search-control" type="text"
                                    placeholder="Search" />
                                <span
                                    class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                                <span
                                    class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close">close</span>
                            </div>
                        </div>
                        <div class="card-body search-content">
                            <!-- Keep empty or add content if needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="navbar-nav gap-1 nav-right-links align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                    data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;">
                    <i class="material-icons-outlined">notifications</i>
                    <span class="badge-notify">5</span>
                </a>
                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="notiy-title mb-0">Notifications</h5>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-icons-outlined">more_vert</span>
                            </button>
                            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                                        class="material-icons-outlined fs-6">inventory_2</i>Archive All</a>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                                        class="material-icons-outlined fs-6">done_all</i>Mark all as read</a>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                                        class="material-icons-outlined fs-6">mic_off</i>Disable Notifications</a>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                                        class="material-icons-outlined fs-6">grade</i>What's new ?</a>
                                <hr class="dropdown-divider" />
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                                        class="material-icons-outlined fs-6">leaderboard</i>Reports</a>
                            </div>
                        </div>
                    </div>
                    <div class="notify-list">
                        <a class="dropdown-item border-bottom py-2" href="javascript:;">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/images/avatars/01.png') }}" class="rounded-circle"
                                    width="45" height="45" alt="" />
                                <div>
                                    <h5 class="notify-title">Congratulations Jhon</h5>
                                    <p class="mb-0 notify-desc">Many congtars jhon. You have won the gifts.</p>
                                    <p class="mb-0 notify-time">Today</p>
                                </div>
                                <div class="notify-close position-absolute end-0 me-3">
                                    <i class="material-icons-outlined fs-6">close</i>
                                </div>
                            </div>
                        </a>
                        <!-- Repeat other notifications as needed -->
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/images/avatars/01.png') }}" class="rounded-circle p-1 border"
                        width="45" height="45" alt="" />
                </a>
                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item gap-2 py-2" href="javascript:;">
                        <div class="text-center">
                            <img src="{{ asset('assets/images/avatars/01.png') }}"
                                class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="" />
                            <h5 class="user-name mb-0 fw-bold">
                                Hello{{ auth()->check() ? ', ' . auth()->user()->name : '' }} !
                            </h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                            class="material-icons-outlined">person_outline</i>Profile</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                            class="material-icons-outlined">local_bar</i>Setting</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                            class="material-icons-outlined">dashboard</i>Dashboard</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                            class="material-icons-outlined">account_balance</i>Earning</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                            class="material-icons-outlined">cloud_download</i>Downloads</a>
                    <hr class="dropdown-divider" />
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                        @method('POST')
                    </form>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:void(0);"
                        onclick="document.getElementById('logout-form').submit();">
                        <i class="material-icons-outlined">power_settings_new</i>Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</header>
