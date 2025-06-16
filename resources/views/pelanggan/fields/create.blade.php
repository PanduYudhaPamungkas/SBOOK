@extends('layouts.layout-pelanggan')

@section('content')

<div class="container py-4 px-5">
    <h2 class="mb-4">Tambah Pesanan</h2>

    <form method="GET" action="{{ url('pelanggan/pesan/create') }}">
        <div class="mb-4 w-25">
            <label for="tanggal" class="form-label">Pilih Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                class="form-control mb-3"
                value="{{ request('tanggal', date('Y-m-d')) }}"
                min="{{ date('Y-m-d') }}"
                onchange="this.form.submit()">
        </div>
    </form>

    <form method="POST" action="{{ url('pelanggan/pesan/store') }}" id="storeForm">
        @csrf
        <input type="hidden" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
        @php
            $orderMap = [];
                foreach ($orders as $order) {
                    if (in_array($order->status, ['pending', 'confirmed'])) {
                        $orderMap[$order->lapangan_id][$order->jam] = true;
                    }
                }
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Jam</th>
                        @foreach ($fields as $field)
                            <th>{{ $field->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @for ($hour = 8; $hour <= 22; $hour++)
                        @php $jamStr = sprintf('%02d:00 - %02d:00', $hour, $hour + 1); @endphp
                        <tr>
                            <td class="fw-bold">{{ $jamStr }}</td>
                            @foreach ($fields as $field)
                                @php
                                    $isBooked = isset($orderMap[$field->id][$jamStr]);
                                @endphp
                                <td>
                                    <input type="checkbox" class="btn-check"
                                        name="selections[]"
                                        id="select-{{ $field->id }}-{{ $hour }}"
                                        value="{{ $field->id }}|{{ $jamStr }}"
                                        data-name="{{ $field->name }}"
                                        {{ $isBooked ? 'disabled' : '' }}>

                                    <label class="btn border border-2 rounded p-2 w-100 select-card {{ $isBooked ? 'bg-secondary text-white' : '' }}"
                                        for="select-{{ $field->id }}-{{ $hour }}">

                                        <p class="fs-6 mb-0">60 Menit</p>
                                        <small class="fs-7">Rp {{ number_format($field->price, 0, ',', '.') }}</small><br>
                                        <small class="fs-7">{{ $isBooked ? 'Booked' : 'Available' }}</small>
                                    </label>
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-primary" onclick="showConfirmation()">Simpan Pesanan</button>
        </div>
    </form>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <ul id="confirmationList" class="list-group">
                <!-- Pesanan akan diisi pakai JS -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-success" onclick="document.getElementById('storeForm').submit();">Konfirmasi & Simpan</button>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
function showConfirmation() {
    const selected = document.querySelectorAll('input[name="selections[]"]:checked');
    const list = document.getElementById('confirmationList');
    list.innerHTML = '';

    if (selected.length === 0) {
        alert('Silakan pilih minimal satu pesanan!');
        return;
    }

    selected.forEach(input => {
        const lapanganName = input.dataset.name;
        const jam = input.value.split('|')[1];

        list.innerHTML += `<li class="list-group-item">
            <strong>${lapanganName}</strong><br>
            Jam: ${jam}
        </li>`;
    });

    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
}
</script>



@endsection
