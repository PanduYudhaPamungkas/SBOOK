@extends('layouts.layout-pemilik')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Pesanan Masuk</h4>
        </div>
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="alert alert-info text-center">
                    Belum ada pesanan.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Pemesan</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Detail Pesanan</th>
                                <th>Harga Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $orderUniqueId => $group)
                                @php
                                    $first = $group->first();
                                    $total = $group->sum(fn($order) => $order->field->price);
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger'
                                    ][$first->status] ?? 'secondary';
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $orderUniqueId }}</td>
                                    <td>{{ $first->user->name }}<br><small>{{ $first->user->email }}</small></td>
                                    <td>{{ \Carbon\Carbon::parse($first->tanggal)->format('d M Y') }}</td>
                                    <td class="text-start">
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($group as $order)
                                                <li>
                                                    <i class="bi bi-check-circle text-success"></i>
                                                    <strong>{{ $order->field->name }}</strong> - {{ $order->jam }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($first->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($first->status === 'pending')
                                            <form method="POST" action="{{ url('pemilik/pesan/data', $orderUniqueId) }}">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm mb-2" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="pending" {{ $first->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed">Confirmed</option>
                                                    <option value="cancelled">Cancelled</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </form>
                                        @else
                                            <span class="text-muted">Tidak dapat diubah</span>
                                        @endif
                                    </td>
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
