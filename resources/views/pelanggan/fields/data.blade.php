@extends('layouts.layout-pelanggan')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Pesanan Anda</h4>
        </div>
        <div class="card-body">
            {{-- Flash message --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

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
                                <th>Tanggal Pemesanan</th>
                                <th>Detail Pesanan</th>
                                <th>Harga</th> {{-- Tambahan --}}
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $orderUniqueId => $group)
                                @php
                                    $first = $group->first();
                                    $status = $first->status ?? 'unknown';
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                    ][$status] ?? 'secondary';

                                    $total = $group->sum(function ($o) {
                                        return $o->field->price;
                                    });
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $orderUniqueId }}</td>
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
                                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($status === 'pending')
                                            <form action="{{ route('pelanggan.order.cancel', $first->id) }}" method="POST" class="cancel-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-sm btn-outline-danger cancel-btn" data-order-id="{{ $first->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Batalkan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
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

<!-- Modal Konfirmasi Pembatalan -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin membatalkan pesanan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBtn">Ya</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let selectedForm = null;

    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function () {
            selectedForm = this.closest('form');
            const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            modal.show();
        });
    });

    document.getElementById('confirmCancelBtn').addEventListener('click', function () {
        if (selectedForm) {
            selectedForm.submit();
        }
    });
</script>
@endsection
