
@extends('layouts.layout-pelanggan')

@section('title', 'Dashboard Pelanggan')

@section('content')
<style>
    .hero-section {
        padding: 3rem 1rem;
        background-image: url('https://lh3.googleusercontent.com/p/AF1QipNYpYQuVpo0QDJOtTS0WsFZY6AzmIUuhzILAaMS=s1360-w1360-h1020-rw');
        background-size: cover;
        background-position: center;
        min-height: 100vh; 
        display: flex;
        align-items: center;
        position: relative;
        background-attachment: fixed; 
        background-repeat: no-repeat; 
        margin: 0; 
        width: 100%;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 0; 
    }

    .hero-text {
        position: relative;
        z-index: 1;
        width: 100%; 
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
    }
</style>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 hero-text mb-4 mb-md-0">
                <h1>Main Badminton <br>Jadi Makin Praktis!</h1>
                <p>Sewa Lapangan di Lapangan 8 Jember kini makin mudah. <br> 
                    hadir sebagai platform booking jadwal sewa lapangan, dimana saja dan kapan saja.</p>
                <a href="{{ url('/pelanggan/pesan') }}" class="btn btn-gradient">Pesan Sekarang!</a>
            </div>
        </div>
    </div>
</section>
@endsection