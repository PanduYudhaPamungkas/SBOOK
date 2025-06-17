<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan </title>

    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Vite for custom app styles/scripts (Tailwind, if needed)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light"> --}}

    <style>
        .btn-check:checked + .select-card {
            border: 2px solid red;
            background-color: #f3a0a0;
            
        }

        .fs-7 {
            font-size: 0.8rem !important
        }
    </style>

    {{-- Navbar Pelanggan --}}
    @include('components.navbar-pelanggan')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    @include('components.footer')

    {{-- Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Cegah tombol back kembali ke login/register --}}
    @auth
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    @endauth

    @yield('js')

</body>
</html>

