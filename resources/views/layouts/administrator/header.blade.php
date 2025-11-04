<div class="shadow-header"></div>

<header class="header-navbar fixed">
    <div class="header-wrapper">
        <div class="header-left">
            <div class="sidebar-toggle action-toggle"><i class="fas fa-bars"></i></div>

        </div>
        <div class="header-content">
            <div class="theme-switch-icon" style="display: none;"></div>
            <div class="notification dropdown me-3">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <span class="badge">12</span>
                </a>
                <ul class="dropdown-menu medium" style="z-index: 9999;">
                    <li class="menu-header">
                        <a class="dropdown-item" href="#">Notification</a>
                    </li>
                    <li class="menu-content ps-menu">
                        <a href="#">
                            <div class="message-icon text-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="message-content read">
                                <div class="body">
                                    There's incoming event, don't miss it!!
                                </div>
                                <div class="time">Just now</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-icon text-info">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="message-content read">
                                <div class="body">
                                    Your licence will expired soon
                                </div>
                                <div class="time">3 hours ago</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-icon text-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="message-content">
                                <div class="body">
                                    Successfully register new user
                                </div>
                                <div class="time">8 hours ago</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown dropdown-menu-end" style="z-index: 9999 !important;">
                <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="label">
                        <span></span>
                        <div>{{ Auth::user()->name ?? 'User' }}</div>
                    </div>
                    @if (empty(auth()->user()->karyawan->foto))
                        <img class="img-user rounded-circle" src="{{ asset('assets/images/avatar1.png') }}"
                            alt="user" style="object-fit: cover; aspect-ratio: 1:1;">
                    @else
                        <img class="img-user rounded-circle"
                            src="https://e-rsudlangsa.id/hrd/user/images/profil/{{ auth()->user()->karyawan->foto }}"
                            alt="user" style="object-fit: cover; aspect-ratio: 1:1;">
                    @endif
                </a>
                <ul class="dropdown-menu" style="z-index: 9999 !important;">
                    <li>
                        <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">
                            <i class="ti-user"></i> Profile
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ env('SSO_BASE_URI', route('logout')) }}">
                            <i class="ti-power-off"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
