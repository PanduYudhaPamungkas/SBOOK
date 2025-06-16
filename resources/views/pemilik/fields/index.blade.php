@extends('layouts.layout-pemilik')

@section('content')

<div class="container py-4">

    {{-- HEADER + TOMBOL TAMBAH --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0" style="color: #e31e25;">📋 Daftar Lapangan</h2>
        <a href="{{ route('fields.create') }}" class="btn btn-warning text-dark fw-semibold shadow-sm">
            + Tambah Lapangan
        </a>
    </div>

    {{-- KONTEN DAFTAR LAPANGAN --}}
    <div class="row g-4">
        @forelse($fields as $field)
        <div class="col-6">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden d-flex flex-row">

                {{-- FOTO --}}
                <div class="col-md-4">
                    @if($field->photo)
                        <img src="{{ asset('storage/' . $field->photo) }}" class="img-fluid h-100 w-100 object-fit-cover" style="object-fit: cover;" alt="{{ $field->name }}">
                    @else
                        <div class="bg-secondary text-white d-flex justify-content-center align-items-center h-100" style="height: 200px;">
                            Tidak Ada Gambar
                        </div>
                    @endif
                </div>

                {{-- DETAIL --}}
                <div class="col-md-8 p-4 d-flex flex-column justify-content-between">
                    <div>
                        {{-- NAMA --}}
                        <h5 class="fw-bold text-dark">{{ $field->name }}</h5>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <span class="fw-semibold me-2">Status:</span>
                            @if($field->available)
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #ffc107; color: #212529;">
                                    ✅ Available
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 text-white" style="background-color: #e31e25;">
                                    ❌ Tidak Tersedia
                                </span>
                            @endif
                        </div>

                        {{-- INFO LAIN --}}
                        <div class="d-flex flex-wrap gap-3 text-dark">
                            <div>
                                <i class="bi bi-currency-dollar me-1 text-warning"></i>
                                Harga: Rp{{ number_format($field->price, 0, ',', '.') }}/jam
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('pemilik.lapangan.detail', ['lapanganId' => $field->id, 'tanggal' => date('Y-m-d')]) }}"
                        class="btn text-white fw-semibold px-3" style="background-color: #e31e25;">
                            Lihat Jadwal
                        </a>
                        <a href="{{ route('fields.edit', $field->id) }}" class="btn btn-outline-primary fw-semibold px-3">
                             <i class="bi bi-pencil-square"></i> Edit Lapangan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted">Belum ada lapangan ditambahkan.</div>
        @endforelse
    </div>
</div>

@endsection
