@extends('layouts.layout-pemilik')

@section('content')
<div class="container py-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Lapangan: {{ $lapangan->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/' . $lapangan->photo) }}" alt="Foto Lapangan" class="img-fluid rounded shadow" style="max-height: 250px; object-fit: cover;">
                </div>
                <div class="col-md-8">
                    <h5 class="fw-bold">{{ $lapangan->name }}</h5>
                    <p class="mb-2">
                        <i class="bi bi-cash-coin text-success"></i>
                        <strong>Harga:</strong> Rp {{ number_format($lapangan->price, 0, ',', '.') }}
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-check-circle {{ $lapangan->available ? 'text-success' : 'text-danger' }}"></i>
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $lapangan->available ? 'success' : 'danger' }}">
                            {{ $lapangan->available ? 'Available' : 'Tidak Tersedia' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pemilik.lapangan.detail', [$lapangan->id, $tanggal]) }}">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label for="tanggal" class="col-form-label">Pilih Tanggal:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="tanggal" name="tanggal" class="form-control"
                            value="{{ $tanggal }}" onchange="changeTanggal(this.value)">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <a href="{{ route('fields.index') }}" class="btn btn-outline-danger  fw-semibold mb-3 px-4 py-2 shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Daftar Lapangan
            </a>
            @if ($orders->isEmpty())
                <div class="alert alert-info text-center">Tidak ada pemesanan pada tanggal ini.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal Pemesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->jam }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function changeTanggal(value) {
    let url = "{{ url('pemilik/lapangan/' . $lapangan->id . '/detail') }}/" + value;
    window.location.href = url;
}
</script>
@endsection
