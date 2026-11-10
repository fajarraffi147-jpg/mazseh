<x-layouts.app :title="'Kuitansi Pembayaran ' . $order->kode_booking . ' | MAZSEH'">
    @php
        $car = $order->mobil;
        $paid = $order->pembayaran ? (float) $order->pembayaran->jumlah_bayar : 0;
        $total = (float) $order->total_harga;
        $due = max(0, $total - $paid);
    @endphp

    <div class="container">
        <div class="panel success-page" style="margin-top:32px;">
            <div class="od-row" style="justify-content:space-between; margin-bottom:16px;">
                <a class="brand" href="{{ route('home') }}">
                    <div>
                        <span class="brand-name">MAZ<span>SEH</span></span>
                        <span class="brand-caption">YOUR JOURNEY, OUR DRIVE</span>
                    </div>
                </a>
                <span class="badge {{ $order->pembayaran && $order->pembayaran->status_pembayaran === 'lunas' ? 'green' : 'amber' }}">
                    {{ $order->pembayaran && $order->pembayaran->status_pembayaran === 'lunas' ? 'LUNAS' : 'PENDING' }}
                </span>
            </div>

            <hr class="rule">

            <h1 style="font-size:26px;" tabindex="-1">Kuitansi Resmi Pembayaran</h1>
            <p class="small spaced">Nomor: <strong>{{ $order->kode_booking }}</strong> &bull; Diterbitkan pada {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>

            <div class="summary-line spaced">
                <span>Diterima dari</span>
                <strong>{{ $order->user->name }}</strong>
            </div>
            <div class="summary-line">
                <span>Untuk penyewaan</span>
                <strong>{{ $car->merk_model }} ({{ $car->plat_nomor }})</strong>
            </div>
            <div class="summary-line">
                <span>Periode sewa</span>
                <strong>{{ $order->tanggal_mulai->translatedFormat('d M Y') }} &ndash; {{ $order->tanggal_selesai->translatedFormat('d M Y') }} ({{ $order->duration_days }} hari)</strong>
            </div>
            <div class="summary-line">
                <span>Metode pembayaran</span>
                <strong>{{ $order->pembayaran->metode_pembayaran ?? 'Transfer bank' }}</strong>
            </div>
            <div class="summary-line">
                <span>Nomor referensi</span>
                <strong>{{ $order->pembayaran->referensi_pembayaran ?? 'TRX-' . $order->kode_booking }}</strong>
            </div>
            <div class="summary-line">
                <span>Total sewa</span>
                <strong>{{ $order->formatted_total }}</strong>
            </div>
            <div class="summary-line summary-total">
                <span>Jumlah telah diterima</span>
                <strong style="color:var(--green);">Rp{{ number_format($paid, 0, ',', '.') }}</strong>
            </div>
            <div class="summary-line">
                <span>Sisa tagihan</span>
                <strong>Rp{{ number_format($due, 0, ',', '.') }}</strong>
            </div>

            <p class="tiny muted spaced">
                Dokumen ini merupakan bukti transaksi sah PT MAZSEH RENTAL NUSANTARA. Harap tunjukkan dokumen ini saat serah-terima unit.
            </p>

            <div class="button-row" style="margin-top:32px;">
                <a href="{{ route('orders.show', $order->id_transaksi) }}" class="btn btn-outline">
                    <x-icon name="back" />
                    <span>Kembali ke Pesanan</span>
                </a>
                <button type="button" class="btn btn-dark" onclick="window.print()" style="gap:8px;">
                    <x-icon name="print" />
                    <span>Cetak Kuitansi</span>
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
