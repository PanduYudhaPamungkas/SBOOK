@extends('layouts.layout-pemilik')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">📊 Laporan Transaksi</h4>

    <form method="GET" action="{{ route('pemilik.laporan.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="bulan_awal" class="form-label">Dari Bulan</label>
            <select name="bulan_awal" id="bulan_awal" class="form-select">
                @foreach(range(1, 12) as $b)
                    <option value="{{ str_pad($b, 2, '0', STR_PAD_LEFT) }}"
                        {{ $bulanAwal == str_pad($b, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="bulan_akhir" class="form-label">Sampai Bulan</label>
            <select name="bulan_akhir" id="bulan_akhir" class="form-select">
                @foreach(range(1, 12) as $b)
                    <option value="{{ str_pad($b, 2, '0', STR_PAD_LEFT) }}"
                        {{ $bulanAkhir == str_pad($b, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="tahun" class="form-label">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
                @foreach(range(date('Y'), 2020) as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    {{-- Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="alert alert-info">⏱️ Total Jam Sewa: <strong>{{ $totalJam }} jam</strong></div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-success">💰 Total Pemasukan: <strong>Rp {{ number_format($totalUang, 0, ',', '.') }}</strong></div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="card mb-4">
        <div class="card-body">
            <canvas id="laporanChart"></canvas>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Data Transaksi Selesai</h5>
        </div>
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="alert alert-info text-center">Tidak ada data transaksi.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Tanggal</th>
                                <th>Detail Pesanan</th>
                                <th>Total Jam</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $group)
                                @php
                                    $first = $group->first();
                                    $jumlahJam = $group->count();
                                    $jumlahHarga = $group->sum('field.price');
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $first->order_unique_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($first->tanggal)->format('d M Y') }}</td>
                                    <td class="text-start">
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($group as $order)
                                                <li>
                                                    <strong>{{ $order->field->name }}</strong> - {{ $order->jam }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $jumlahJam }} jam</td>
                                    <td>Rp {{ number_format($jumlahHarga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('laporanChart').getContext('2d');
    const laporanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jam Total', 'Pemasukan (Rp)'],
            datasets: [
                {
                    label: 'Jam Total',
                    data: [{{ $totalJam ?? 0 }}, null],
                    backgroundColor: '#0d6efd',
                    yAxisID: 'y',
                },
                {
                    label: 'Pemasukan (Rp)',
                    data: [null, {{ $totalUang ?? 0 }}],
                    backgroundColor: '#198754',
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left',
                    title: { display: true, text: 'Jam' }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: 'Pemasukan (Rp)' }
                }
            }
        }
    });
</script>
@endsection
