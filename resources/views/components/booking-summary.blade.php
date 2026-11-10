@props(['car', 'start', 'end', 'time' => '09:00', 'service' => 'Lepas kunci'])

@php
    $startDate = \Carbon\Carbon::parse($start);
    $endDate = \Carbon\Carbon::parse($end);
    $days = max(1, $startDate->diffInDays($endDate));
    $dailyRate = (float) $car->harga_sewa;
    $driverRate = ($service === 'Dengan sopir') ? 200000 : 0;
    $rentalTotal = $dailyRate * $days;
    $driverTotal = $driverRate * $days;
    $grandTotal = $rentalTotal + $driverTotal;
@endphp

<aside class="panel sticky-panel">
    <h3>Ringkasan sewa</h3>
    <div class="mini-car spaced">
        <img src="{{ asset($car->foto_mobil ?? 'assets/avanza.png') }}" width="600" height="400" alt="{{ $car->merk_model }}">
        <div>
            <h3>{{ $car->merk_model }}</h3>
            <p>{{ $car->kategori->nama_kategori ?? 'Armada' }} &bull; {{ $car->jumlah_kursi }} kursi</p>
        </div>
    </div>

    <div class="summary-line">
        <span>Pengambilan</span>
        <strong>{{ $startDate->translatedFormat('d M Y') }}<br>{{ $time }} WIB</strong>
    </div>
    <div class="summary-line">
        <span>Pengembalian</span>
        <strong>{{ $endDate->translatedFormat('d M Y') }}<br>{{ $time }} WIB</strong>
    </div>
    <div class="summary-line">
        <span>Lokasi Unit</span>
        <strong>{{ $car->kota }}</strong>
    </div>

    <hr class="rule">

    <div class="summary-line">
        <span>{{ $car->formatted_price }} &times; {{ $days }} hari</span>
        <strong>Rp{{ number_format($rentalTotal, 0, ',', '.') }}</strong>
    </div>
    <div class="summary-line">
        <span>Sopir {{ $driverRate ? '&times; ' . $days . ' hari' : '' }}</span>
        <strong>{{ $driverRate ? 'Rp' . number_format($driverTotal, 0, ',', '.') : 'Tidak dipilih' }}</strong>
    </div>
    <div class="summary-line summary-total">
        <span>Total sewa</span>
        <strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong>
    </div>

    <p class="tiny muted spaced">Tarif transparan. Bahan bakar, tol, parkir, dan opsi pengantaran di luar pool disesuaikan saat serah-terima.</p>
</aside>
