<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            🚍 Live Pickup
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <!-- LEFT MENU -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">

                {{-- ================= ADMIN / SUPER ADMIN ================= --}}
                @if(in_array(auth()->user()->role, ['admin', 'super_admin']))

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <!-- Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-gear"></i> Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">👥 Users</a></li>
                        <li><a class="dropdown-item" href="{{ route('students.index') }}">🎓 Students</a></li>
                        <li><a class="dropdown-item" href="{{ route('student-parents.index') }}">👨‍👩‍👧 Parents</a></li>
                        <li><a class="dropdown-item" href="{{ route('drivers.index') }}">🧑‍✈️ Drivers</a></li>
                        <li><a class="dropdown-item" href="{{ route('buses.index') }}">🚍 Buses</a></li>
                    </ul>
                </li>

                <!-- Trips & Routes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        🛣 Operations
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('routes.index') }}">Routes</a></li>
                        <li><a class="dropdown-item" href="{{ route('trips.index') }}">Trips</a></li>
                        <li><a class="dropdown-item" href="{{ route('bus-students.index') }}">Assign Students</a></li>
                        <li><a class="dropdown-item" href="{{ route('pickup-points.index') }}">Pickup Points</a></li>
                    </ul>
                </li>

                <!-- Live Tracking -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-primary fw-semibold" href="#" data-bs-toggle="dropdown">
                        🗺 Live Tracking
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('gps.live.view') }}">Live Bus Tracking</a></li>
                        <li><a class="dropdown-item" href="{{ route('gps.live.pickups.view') }}">Live Student Pickups</a></li>
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
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('driver.trips') }}">Assigned Trips</a></li>
                        <li><a class="dropdown-item" href="{{ route('driver.pickups.student.live') }}">Live Pickup Route</a></li>
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
                    <ul class="dropdown-menu">
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

            <!-- RIGHT MENU (USER DROPDOWN) -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                👤 Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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
