<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register | School Transport System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Create Account 🚍</h4>
                            <p class="text-muted mb-0">Join the School Transport System</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="John Doe"
                                    required autofocus>

                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="name@example.com"
                                    required>

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
                                        onclick="togglePassword('password', 'eyePassword')">
                                        <i id="eyePassword" class="bi bi-eye"></i>
                                    </button>
                                </div>

                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    Confirm Password
                                </label>

                                <div class="input-group">
                                    <input id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="••••••••"
                                        required>

                                    <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('password_confirmation', 'eyeConfirm')">
                                        <i id="eyeConfirm" class="bi bi-eye"></i>
                                    </button>
                                </div>

                                @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="d-grid mt-4">
                                <button type="submit"
                                    class="btn btn-primary btn-lg rounded-3">
                                    📝 Register
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none small">
                                    Already registered? Login
                                </a>
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
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

</body>

</html>