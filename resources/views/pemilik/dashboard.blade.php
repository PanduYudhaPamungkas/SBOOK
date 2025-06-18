@extends('layouts.layout-pemilik')

@section('title', 'Dashboard Pemilik')

@section('content')
    <div class="bg-white shadow-sm border-bottom mb-4">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 fw-bold text-dark mb-2">
                        Selamat Datang, <span class="text-danger">{{ Auth::user()->name }}</span>! 👋
                    </h1>
                    <p class="text-muted mb-0 fs-5">Mari kelola lapangan Anda dengan mudah</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="me-3">
                            <p class="small text-muted mb-0">{{ date('l, d F Y') }}</p>
                            <p class="small text-muted mb-0">{{ date('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-4">
            @if ($pendingCount >= 1)
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow-lg h-100 bg-warning">
                        <div class="card-body p-4 text-white">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                        <h4 class="card-title fw-bold mb-0">Perlu Perhatian!</h4>
                                    </div>
                                    <p class="card-text mb-3">
                                        Terdapat <span class="fw-bold fs-3">{{$pendingCount}}</span> pesanan menunggu konfirmasi
                                    </p>
                                    <a href="{{url('/pemilik/pesan/data')}}" class="btn btn-light text-warning fw-semibold">
                                        <i class="fas fa-eye me-2"></i>Lihat Pesanan
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                                <div class="col-md-4 text-center d-none d-md-block">
                                    <div class="bg-light bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                        <i class="fas fa-clipboard-list fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow-lg h-100 bg-success">
                        <div class="card-body p-4 text-white">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-check-circle fa-2x me-3"></i>
                                        <h4 class="card-title fw-bold mb-0">Semua Lancar!</h4>
                                    </div>
                                    <p class="card-text mb-3">
                                        Tidak ada pesanan yang menunggu konfirmasi
                                    </p>
                                    <div class="badge bg-light text-success fs-6 py-2 px-3">
                                        <i class="fas fa-thumbs-up me-2"></i>Status: Terkendali
                                    </div>
                                </div>
                                <div class="col-md-4 text-center d-none d-md-block">
                                    <div class="bg-light bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                        <i class="fas fa-check-double fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-dark mb-4">
                            <i class="fas fa-chart-bar text-primary me-2"></i>Ringkasan Hari Ini
                        </h5>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2">
                                    <div class="fs-2 fw-bold text-primary">{{$pendingCount}}</div>
                                    <div class="small text-muted">Menunggu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection