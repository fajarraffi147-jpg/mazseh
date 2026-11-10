<x-layouts.app :title="'Pembayaran Pesanan ' . $transaksi->kode_booking . ' | MAZSEH'">
    @php
        $car = $transaksi->mobil;
        $totalAmount = (float) $transaksi->total_harga;
        $paidAmount = $transaksi->pembayaran ? (float) $transaksi->pembayaran->jumlah_bayar : 0;
        $isPaid = $transaksi->pembayaran && $transaksi->pembayaran->status_pembayaran === 'lunas';
    @endphp

    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                <x-icon name="chevron" />
                <a href="{{ route('orders.show', $transaksi->id_transaksi) }}">{{ $transaksi->kode_booking }}</a>
                <x-icon name="chevron" />
                <span>Pembayaran</span>
            </div>
            <div class="page-title">
                <h1>Pembayaran pesanan {{ $transaksi->kode_booking }}</h1>
                <p>Selesaikan pembayaran untuk mengonfirmasi jadwal sewa armada Anda.</p>
            </div>
        </div>

        <div class="two-col section-small">
            <div class="panel">
                <h2 style="font-size:24px; margin-bottom:6px;">Pilih metode pembayaran</h2>
                <p class="panel-subtitle">{{ $car->merk_model }} &bull; {{ $transaksi->tanggal_mulai->translatedFormat('d M Y') }} s/d {{ $transaksi->tanggal_selesai->translatedFormat('d M Y') }} ({{ $transaksi->duration_days }} hari)</p>

                @if($isPaid)
                    <div class="notice success" style="margin-top:20px;">
                        <x-icon name="check" />
                        <span>Pembayaran untuk pesanan ini telah <strong>LUNAS</strong>. Silakan periksa detail pesanan atau cetak kuitansi resmi Anda.</span>
                    </div>
                    <div style="margin-top:24px;">
                        <a href="{{ route('orders.show', $transaksi->id_transaksi) }}" class="btn btn-primary">Lihat Detail Pesanan</a>
                        <a href="{{ route('orders.receipt', $transaksi->id_transaksi) }}" class="btn btn-outline" style="margin-left:12px;">Cetak Kuitansi</a>
                    </div>
                @else
                    <form action="{{ route('orders.payment.submit', $transaksi->id_transaksi) }}" method="POST" enctype="multipart/form-data" style="margin-top:24px;">
                        @csrf
                        <div class="field">
                            <label for="metode_pembayaran">Metode pembayaran</label>
                            <select id="metode_pembayaran" name="metode_pembayaran">
                                <option value="Transfer bank" {{ old('metode_pembayaran') === 'Transfer bank' ? 'selected' : '' }}>Transfer Bank (BCA / Mandiri / BNI / BRI)</option>
                                <option value="QRIS" {{ old('metode_pembayaran') === 'QRIS' ? 'selected' : '' }}>QRIS (Gopay, OVO, Dana, ShopeePay, Mobile Banking)</option>
                                <option value="Tunai di kasir" {{ old('metode_pembayaran') === 'Tunai di kasir' ? 'selected' : '' }}>Bayar Tunai di Kasir / Pool MAZSEH</option>
                            </select>
                        </div>

                        <!-- Payment instructions box -->
                        <div class="panel" style="background:#f8fafc; border-color:#e2e8f0; margin-bottom:20px;">
                            <h4 style="margin-bottom:8px;">Instruksi Pembayaran</h4>
                            <p class="small" id="pay-instruction">
                                Silakan transfer ke rekening resmi MAZSEH:<br>
                                <strong>BCA: 800-992-1234</strong> a.n. <strong>PT MAZSEH RENTAL NUSANTARA</strong><br>
                                Cantumkan kode booking <strong>{{ $transaksi->kode_booking }}</strong> pada berita transfer.
                            </p>
                        </div>

                        <div class="field">
                            <label for="referensi_pembayaran">Nomor Referensi Transfer / No. Transaksi (Opsional)</label>
                            <input type="text" id="referensi_pembayaran" name="referensi_pembayaran" value="{{ old('referensi_pembayaran') }}" placeholder="Contoh: TRX-12345678">
                        </div>

                        <div class="field">
                            <label for="bukti_bayar">Upload Bukti Transfer / Resi (Opsional)</label>
                            <input type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*">
                        </div>

                        <label class="check-label spaced">
                            <input type="checkbox" name="consent" required checked>
                            <span>Saya mengonfirmasi data transaksi pembayaran ini sudah sesuai.</span>
                        </label>

                        <div class="button-row" style="margin-top:24px;">
                            <a href="{{ route('orders.show', $transaksi->id_transaksi) }}" class="btn btn-outline">Kembali ke Pesanan</a>
                            <button type="submit" class="btn btn-primary" style="padding-inline:24px;">Konfirmasi Pembayaran</button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Right bill summary -->
            <aside class="panel">
                <h3>Tagihan Anda</h3>
                <div class="summary-line spaced">
                    <span>Total sewa</span>
                    <strong>{{ $transaksi->formatted_total }}</strong>
                </div>
                <div class="summary-line">
                    <span>Sudah dibayar</span>
                    <strong>Rp{{ number_format($paidAmount, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-line summary-total">
                    <span>Sisa pembayaran</span>
                    <strong>Rp{{ number_format(max(0, $totalAmount - $paidAmount), 0, ',', '.') }}</strong>
                </div>

                <div class="spaced">
                    <span class="badge {{ $transaksi->status_badge_class }}" style="display:block; text-align:center; padding:8px;">
                        Status: {{ $transaksi->status_label }}
                    </span>
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('metode_pembayaran')?.addEventListener('change', function() {
            const instr = document.getElementById('pay-instruction');
            if (this.value === 'QRIS') {
                instr.innerHTML = 'Scan kode QRIS MAZSEH melalui aplikasi e-wallet atau mobile banking favorit Anda. Pembayaran akan terverifikasi secara otomatis.';
            } else if (this.value === 'Tunai di kasir') {
                instr.innerHTML = 'Silakan lakukan pembayaran tunai secara langsung di loket kasir pool MAZSEH saat pengambilan atau serah-terima unit.';
            } else {
                instr.innerHTML = 'Silakan transfer ke rekening resmi MAZSEH:<br><strong>BCA: 800-992-1234</strong> a.n. <strong>PT MAZSEH RENTAL NUSANTARA</strong><br>Cantumkan kode booking <strong>{{ $transaksi->kode_booking }}</strong> pada berita transfer.';
            }
        });
    </script>
    @endpush
</x-layouts.app>
