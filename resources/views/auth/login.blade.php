<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Penyewaan Lapangan Badminton</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .login-container {
            height: 100vh;
            align-items: center;
        }
        .login-box {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 90vh;
            max-height: 700px;

        }
        .login-form {
            padding: 3rem;
            background: white;
        }
        .login-image {
            background-image: url('https://lh3.googleusercontent.com/p/AF1QipOqEEXMd9J9T4i3mWEWRMFM06-jo8pTjaStYbb2=w750-h606-p-k-no');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(49, 44, 44, 0.6); /* Changed to #781113 with opacity */
        }
        .login-title {
            font-weight: 700;
            color: #e31e25; /* Changed to #e31e25 */
        }
        .login-subtitle {
            color: #6c757d;
        }
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #e31e25; /* Changed to #e31e25 */
            box-shadow: 0 0 0 0.25rem rgba(227, 30, 37, 0.25); /* Changed to #e31e25 */
        }
        .btn-login {
            background-color: #e31e25; /* Changed to #e31e25 */
            border: none;
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-login:hover {
            background-color: #781113; /* Changed to #781113 */
        }
        .btn-google {
            background-color: white;
            border: 1px solid #ced4da;
            height: 50px;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-google:hover {
            background-color: #f8f9fa;
        }
        .form-check-input:checked {
            background-color: #e31e25; /* Changed to #e31e25 */
            border-color: #e31e25; /* Changed to #e31e25 */
        }
        .forgot-link {
            color: #6c757d;
            text-decoration: none;
        }
        .forgot-link:hover {
            color: #e31e25; /* Changed to #e31e25 */
        }
        .register-text {
            color: #6c757d;
        }
        .register-link {
            color: #e31e25; /* Changed to #e31e25 */
            font-weight: 600;
            text-decoration: none;
        }
        .image-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 2rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .alert-danger {
            background-color: rgba(227, 30, 37, 0.1); /* Changed to #e31e25 with opacity */
            border-color: rgba(227, 30, 37, 0.3); /* Changed to #e31e25 with opacity */
            color: #e31e25; /* Changed to #e31e25 */
        }
        @media (max-width: 991.98px) {
            .login-image {
                display: none;
            }
            .login-form {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    @php
        use Illuminate\Support\Str;

        $usernameError = $errors->first('username');
        $passwordError = $errors->first('password');

        $showCredentialError = Str::contains($usernameError, 'These credentials');
        $showRequiredError = Str::contains($usernameError, 'required') || Str::contains($passwordError, 'required');
    @endphp
    <div class="container-fluid login-container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10">
                <div class="login-box d-flex">
                    <!-- Form Login (Kiri) -->
                    <div class="login-form col-md-6 d-flex align-items-center">
                        <div class="w-100">
                            <div class="text-center mb-5">
                                <h2 class="login-title mt-2">SELAMAT DATANG KEMBALI</h2>
                                <p class="login-subtitle">Silakan masuk dengan akun Anda</p>
                            </div>

                            @if ($showCredentialError)
                                <div class="alert alert-danger mb-4">
                                    Username atau password salah
                                </div>
                            @elseif ($showRequiredError)
                                <div class="alert alert-danger mb-4">
                                    Data harus diisi
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" novalidate>
                                @csrf

                                <!-- Username -->
                                <div class="mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ old('username') }}" placeholder="Masukkan username Anda" required autofocus>
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Masukkan kata sandi" required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fa fa-eye-slash" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>

{{-- 
                                <!-- Ingat Saya & Lupa Password -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label" for="remember_me">Ingat saya</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                                </div> --}}

                                <!-- Tombol Masuk -->
                                <button type="submit" class="btn btn-login btn-primary w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> MASUK
                                </button>

                                <!-- Daftar Akun -->
                                <p class="text-center register-text">Belum punya akun?
                                    <a href="{{ route('register') }}" class="register-link">Daftar gratis!</a>
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Gambar (Kanan) -->
                    <div class="login-image col-md-6 d-none d-md-block">
                        <div class="image-content">
                            <h1 class="display-4 fw-bold mb-4">8<span class="text-warning">BOOK</span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passwordField && eyeIcon) {
                toggleBtn.addEventListener('click', () => {
                    const type = passwordField.type === 'password' ? 'text' : 'password';
                    passwordField.type = type;

                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
