<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | School Transport System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Welcome Back 👋</h4>
                            <p class="text-muted mb-0">Login to continue</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                        <div class="alert alert-success small">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="name@example.com"
                                    required autofocus>

                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>

                                <div class="input-group">
                                    <input id="password"
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="••••••••"
                                        required>

                                    <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword()">
                                        <i id="eyeIcon" class="bi bi-eye"></i>
                                    </button>

                                    @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember_me">
                                    <label class="form-check-label small" for="remember_me">
                                        Remember me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="small text-decoration-none">
                                    Forgot password?
                                </a>
                                @endif
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit"
                                    class="btn btn-primary btn-lg rounded-3">
                                    🔐 Log In
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-muted small mt-3">
                    © {{ date('Y') }} EDURIDE | IRERERO Academy
                </p>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

</body>

</html>