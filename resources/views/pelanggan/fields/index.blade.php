@extends('layouts.layout-pelanggan')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Lapangan</h2>
        <a href="{{ url('pelanggan/pesan/create') }}" class="btn btn-primary">
            Tambah Pesanan
        </a>
    </div>

    <div class="row">
        @forelse ($fields as $field)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            @if ($field->photo)
                                <img src="{{ asset('storage/' . $field->photo) }}" class="img-fluid rounded-start" alt="{{ $field->name }}">
                            @else
                                <img src="{{ asset('images/images.jpeg') }}" class="img-fluid rounded-start" alt="Default Field">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $field->name }}</h5>
                                <p class="card-text mb-1">
                                    Harga: Rp {{ number_format($field->price, 0, ',', '.') }} / jam
                                </p>
                                <p class="card-text">
                                    Status:
                                    @if ($field->available)
                                        <span class="badge bg-success">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Tersedia</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada lapangan yang tersedia saat ini.</p>
        @endforelse
    </div>
</div>

@endsection
