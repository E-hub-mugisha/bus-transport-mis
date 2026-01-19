<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password | School Transport System</title>

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
                            <h4 class="fw-bold">🔐 Forgot Password</h4>
                            <p class="text-muted mb-0">
                                Enter your email and we’ll send you a reset link
                            </p>
                        </div>

                        <!-- Status Message -->
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>

                                    <input id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="name@example.com"
                                        required autofocus>
                                </div>

                                @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="d-grid mt-4">
                                <button type="submit"
                                    class="btn btn-primary btn-lg rounded-3">
                                    📧 Send Password Reset Link
                                </button>
                            </div>

                            <!-- Back to login -->
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none small">
                                    ← Back to Login
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

</body>

</html>