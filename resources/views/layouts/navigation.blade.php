<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm modern-navbar">
    <div class="container-fluid px-4">

        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
            href="{{ route('dashboard') }}">
            <span class="logo-icon">🚍</span>
            <span class="logo-text">Live Pickup</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <i class="bi bi-list fs-2"></i>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <!-- CENTER MENU -->
            <ul class="navbar-nav mx-auto align-items-center gap-lg-2">

                {{-- ================= ADMIN / SUPER ADMIN ================= --}}
                @if(in_array(auth()->user()->role, ['admin', 'super_admin']))

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Management -->

                <li class="nav-item"><a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}">Students</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('student-parents.index') ? 'active' : '' }}" href="{{ route('student-parents.index') }}">Parents</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('drivers.index') ? 'active' : '' }}" href="{{ route('drivers.index') }}">Drivers</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('buses.index') ? 'active' : '' }}" href="{{ route('buses.index') }}">Buses</a></li>


                <!-- Operations -->

                <li class="nav-item"><a class="nav-link" href="{{ route('routes.index') }}">Routes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('trips.index') }}">Trips</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bus-students.index') }}">Assign Students</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('pickup-points.index') }}">Pickup Points</a></li>


                <!-- Live Tracking -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-primary fw-semibold"
                        href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-geo-alt-fill"></i> Live Tracking
                    </a>
                    <ul class="dropdown-menu dropdown-menu-animate">
                        <li class="dropdown-item">
                            <a class="nav-link {{ request()->is('admin/map') ? 'active' : '' }}"
                                href="{{ route('admin.map') }}">
                                <i class="bi bi-geo-alt"></i> Live GPS Tracking
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('gps.live.view') }}">🗺 Bus Tracking</a></li>
                        <li><a class="dropdown-item" href="{{ route('gps.live.pickups.view') }}">🎯 Student Pickups</a></li>
                    </ul>
                </li>

                @endif

                {{-- ================= DRIVER ================= --}}
                @if(auth()->user()->role === 'driver')

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('driver.dashboard') }}">
                        🚍 Driver Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        📅 My Trips
                    </a>
                    <ul class="dropdown-menu dropdown-menu-animate">
                        <li><a class="dropdown-item" href="{{ route('driver.trips') }}">Assigned Trips</a></li>
                        <li><a class="dropdown-item" href="{{ route('driver.pickups.student.live') }}">Live Pickup</a></li>
                        <li><a class="dropdown-item" href="{{ route('driver.students') }}">Students on Bus</a></li>
                    </ul>
                </li>

                @endif

                {{-- ================= PARENT / STUDENT ================= --}}
                @if(auth()->user()->role === 'user')

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        🎓 My Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        🚍 Bus Info
                    </a>
                    <ul class="dropdown-menu dropdown-menu-animate">
                        <li><a class="dropdown-item" href="{{ route('user.bus.tracking') }}">Real-time Tracking</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.schedule') }}">Bus Schedule</a></li>
                        <li><a class="dropdown-item" href="{{ route('trip.history') }}">Trip History</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.notifications') }}">
                        🔔 Notifications
                    </a>
                </li>

                @endif
            </ul>

            <!-- USER MENU -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-menu" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animate">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                👤 Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    🚪 Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>