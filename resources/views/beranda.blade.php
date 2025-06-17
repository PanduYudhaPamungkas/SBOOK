<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>8BOOK - Sewa Lapangan Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar {
            padding: 0.8rem 1rem;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: #e31e25;
        }

        .navbar-brand span {
            color: #ffc107;
        }

        .auth-btn {
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-login {
            border: 2px solid #e31e25;
            color: #e31e25;
            margin-right: 10px;
        }

        .btn-login:hover {
            background-color: #e31e25;
            color: white;
        }

        .btn-register {
            background-color: #e31e25;
            color: white;
            border: 2px solid #e31e25;
        }

        .btn-register:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .hero-section {
            padding: 3rem 1rem;
            background-image: url('https://lh3.googleusercontent.com/p/AF1QipNYpYQuVpo0QDJOtTS0WsFZY6AzmIUuhzILAaMS=s1360-w1360-h1020-rw');
            background-size: cover;
            background-position: center;
            min-height: 88.1vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .hero-text {
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .hero-text p {
            font-size: 1.3rem;
            color: white;
            margin-top: 1rem;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }

        .btn-gradient {
            background: linear-gradient(90deg, #e31e25, #ff6b6b);
            color: white;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            border: none;
            box-shadow: 0 4px 15px rgba(227, 30, 37, 0.4);
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(227, 30, 37, 0.6);
        }

        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2rem;
            }

            .hero-text {
                text-align: center;
            }

            .auth-buttons {
                display: flex;
                gap: 0.5rem;
            }

            .btn-login,
            .btn-register {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span>8</span>BOOK
            </a>

            <div class="auth-buttons">
                @auth
                    @if (Auth::user()->role === 'pelanggan')
                        <a href="{{ route('pelanggan.dashboard') }}" class="auth-btn btn-login">Dashboard</a>
                    @elseif (Auth::user()->role === 'pemilik')
                        <a href="{{ route('pemilik.dashboard') }}" class="auth-btn btn-login">Dashboard</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="auth-btn btn-register btn-danger" style="border: none;">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="auth-btn btn-login">Login</a>
                    <a href="{{ route('register') }}" class="auth-btn btn-register">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 hero-text mb-4 mb-md-0">
                    <h1>Main Badminton <br>Jadi Makin Praktis!</h1>
                    <p>Sewa Lapangan di Lapangan 8 Jember kini makin mudah. 8BOOK hadir sebagai platform booking jadwal sewa lapangan, dimana saja dan kapan saja.</p>

                    @auth
                        @if (Auth::user()->role === 'pelanggan')
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-gradient">Lihat Dashboard</a>
                        @elseif (Auth::user()->role === 'pemilik')
                            <a href="{{ route('pemilik.dashboard') }}" class="btn btn-gradient">Lihat Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-gradient">Coba Sekarang!</a>
                    @endauth

                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
