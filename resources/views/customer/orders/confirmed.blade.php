<x-layouts.app :title="'Konfirmasi Pesanan ' . $transaksi->kode_booking . ' | MAZSEH'">
    <div class="container">
        <div class="panel success-page text-center">
            <div class="success-symbol">
                <x-icon name="check" style="--od-icon-size:32px;" />
            </div>

            <h1 tabindex="-1">Pesanan Anda Berhasil Diproses!</h1>
            <p class="intro">
                Terima kasih telah mempercayakan perjalanan Anda bersama MAZSEH. Detail pesanan telah kami catat dalam sistem.
            </p>

            <span class="badge {{ $transaksi->status_badge_class }}" style="font-size:13px; padding:6px 14px;">
                Status: {{ $transaksi->status_label }}
            </span>

            <div style="max-width:440px; margin:24px auto; text-align:left;">
                <div class="summary-line">
                    <span>Nomor Pesanan</span>
                    <strong>{{ $transaksi->kode_booking }}</strong>
                </div>
                <div class="summary-line">
                    <span>Mobil</span>
                    <strong>{{ $transaksi->mobil->merk_model }}</strong>
                </div>
                <div class="summary-line">
                    <span>Jadwal Sewa</span>
                    <strong>{{ $transaksi->tanggal_mulai->translatedFormat('d M Y') }} &ndash; {{ $transaksi->tanggal_selesai->translatedFormat('d M Y') }} ({{ $transaksi->duration_days }} hari)</strong>
                </div>
                <div class="summary-line">
                    <span>Titik Penjemputan</span>
                    <strong>{{ $transaksi->titik_jemput }}</strong>
                </div>
                <div class="summary-line summary-total">
                    <span>Total Biaya</span>
                    <strong>{{ $transaksi->formatted_total }}</strong>
                </div>
            </div>

            <div class="button-row" style="justify-content:center; margin-top:32px;">
                <a href="{{ route('orders.show', $transaksi->id_transaksi) }}" class="btn btn-primary" style="padding-inline:24px;">Lihat Detail Pesanan</a>
                @if($transaksi->status_pesanan === 'menunggu_pembayaran')
                    <a href="{{ route('orders.payment', $transaksi->id_transaksi) }}" class="btn btn-blue">Bayar Sekarang</a>
                @endif
                <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</x-layouts.app>
