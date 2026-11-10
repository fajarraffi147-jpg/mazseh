<x-layouts.app :title="'Detail Pesanan ' . $order->kode_booking . ' | MAZSEH'">
    @php
        $car = $order->mobil;
        $totalAmount = (float) $order->total_harga;
        $paidAmount = $order->pembayaran ? (float) $order->pembayaran->jumlah_bayar : 0;
        $isPaid = $order->pembayaran && $order->pembayaran->status_pembayaran === 'lunas';
    @endphp

    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                <x-icon name="chevron" />
                <span>{{ $order->kode_booking }}</span>
            </div>
            <div class="page-title">
                <h1>Detail pesanan {{ $order->kode_booking }}</h1>
                <p>Informasi jadwal sewa, status verifikasi, dan rincian transaksi Anda.</p>
            </div>
        </div>

        <div class="two-col section-small">
            <!-- Left detail column -->
            <div>
                <div class="panel">
                    <div class="panel-title">
                        <h2>{{ $order->kode_booking }}</h2>
                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                    </div>

                    <div class="mini-car">
                        <img src="{{ asset($car->foto_mobil ?? 'assets/avanza.png') }}" width="600" height="400" alt="{{ $car->merk_model }}">
                        <div>
                            <h3>{{ $car->merk_model }}</h3>
                            <p>{{ $car->plat_nomor }} &bull; {{ $order->opsi_pengemudi }} &bull; {{ $order->metode_pengambilan }}</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="od-field">
                            <span class="tiny muted">Pengambilan</span>
                            <strong class="small">{{ $order->tanggal_mulai->translatedFormat('d M Y') }}, {{ $order->waktu_ambil }} WIB</strong>
                            <span class="tiny muted">{{ $car->kota }}</span>
                        </div>
                        <div class="od-field">
                            <span class="tiny muted">Pengembalian</span>
                            <strong class="small">{{ $order->tanggal_selesai->translatedFormat('d M Y') }}, {{ $order->waktu_ambil }} WIB</strong>
                            <span class="tiny muted">{{ $order->duration_days }} hari sewa</span>
                        </div>
                    </div>

                    <hr class="rule">

                    <h3>Informasi Penjemputan & Penyewa</h3>
                    <div class="summary-line spaced">
                        <span>Penyewa</span>
                        <strong>{{ $order->user->name }}</strong>
                    </div>
                    <div class="summary-line">
                        <span>Email</span>
                        <strong>{{ $order->user->email }}</strong>
                    </div>
                    <div class="summary-line">
                        <span>Telepon</span>
                        <strong>{{ $order->user->phone ?? '-' }}</strong>
                    </div>
                    <div class="summary-line">
                        <span>Alamat / Titik Jemput</span>
                        <strong>{{ $order->titik_jemput }}</strong>
                    </div>
                    @if($order->latitude && $order->longitude)
                        <div class="summary-line">
                            <span>Koordinat GPS</span>
                            <strong>{{ $order->latitude }}, {{ $order->longitude }}</strong>
                        </div>
                    @endif
                    @if($order->catatan)
                        <div class="summary-line">
                            <span>Catatan</span>
                            <strong>{{ $order->catatan }}</strong>
                        </div>
                    @endif
                    @if($order->alasan_batal)
                        <div class="notice error spaced">
                            <x-icon name="info" />
                            <span><strong>Alasan Pembatalan:</strong> {{ $order->alasan_batal }}</span>
                        </div>
                    @endif
                </div>

                <!-- Timeline Panel -->
                <div class="panel">
                    <h3>Riwayat & Status Pesanan</h3>
                    <ol class="timeline">
                        <li>
                            <span class="timeline-icon done"><x-icon name="check" /></span>
                            <div>
                                <strong>Pesanan Dibuat</strong>
                                <p>{{ $order->waktu_pesan ? $order->waktu_pesan->translatedFormat('d M Y, H:i') : '-' }} WIB</p>
                            </div>
                        </li>
                        <li>
                            <span class="timeline-icon {{ $isPaid ? 'done' : '' }}">
                                <x-icon name="{{ $isPaid ? 'check' : 'clock' }}" />
                            </span>
                            <div>
                                <strong>Pembayaran ({{ $transaksi->pembayaran->status_label ?? 'Pending' }})</strong>
                                <p>
                                    @if($isPaid)
                                        Lunas via {{ $order->pembayaran->metode_pembayaran }} pada {{ $order->pembayaran->waktu_bayar ? $order->pembayaran->waktu_bayar->translatedFormat('d M Y, H:i') : '-' }} WIB
                                    @else
                                        Menunggu penyelesaian pembayaran oleh penyewa
                                    @endif
                                </p>
                            </div>
                        </li>
                        <li>
                            <span class="timeline-icon {{ $order->status_pesanan === 'dikonfirmasi' ? 'done' : '' }}">
                                <x-icon name="{{ $order->status_pesanan === 'dikonfirmasi' ? 'check' : 'clock' }}" />
                            </span>
                            <div>
                                <strong>Konfirmasi Serah-Terima Armada</strong>
                                <p>{{ $order->status_pesanan === 'dikonfirmasi' ? 'Pesanan dikonfirmasi. Unit siap diserahterimakan.' : ($order->status_pesanan === 'dibatalkan' ? 'Pesanan telah dibatalkan.' : 'Menunggu pembayaran terverifikasi.') }}</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Right bill panel -->
            <aside class="panel sticky-panel">
                <h3>Rincian Pembayaran</h3>
                <div class="summary-line spaced">
                    <span>Sewa {{ $order->duration_days }} hari</span>
                    <strong>{{ $order->mobil->formatted_price }} &times; {{ $order->duration_days }}</strong>
                </div>
                <div class="summary-line">
                    <span>Layanan Pengemudi</span>
                    <strong>{{ $order->opsi_pengemudi === 'Dengan sopir' ? 'Rp' . number_format(200000 * $order->duration_days, 0, ',', '.') : 'Tidak dipilih' }}</strong>
                </div>
                <div class="summary-line summary-total">
                    <span>Total Tagihan</span>
                    <strong>{{ $order->formatted_total }}</strong>
                </div>
                <div class="summary-line">
                    <span>Telah Dibayar</span>
                    <strong>Rp{{ number_format($paidAmount, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-line">
                    <span>Sisa Tagihan</span>
                    <strong>Rp{{ number_format(max(0, $totalAmount - $paidAmount), 0, ',', '.') }}</strong>
                </div>

                <hr class="rule">

                @if($order->status_pesanan === 'menunggu_pembayaran')
                    <a href="{{ route('orders.payment', $order->id_transaksi) }}" class="btn btn-primary wfull" style="margin-bottom:12px;">Lanjutkan Pembayaran</a>
                    <button type="button" class="btn btn-outline wfull" id="btn-open-cancel" style="color:var(--red);">Batalkan Pesanan</button>
                @endif

                @if($isPaid)
                    <a href="{{ route('orders.receipt', $order->id_transaksi) }}" class="btn btn-outline wfull spaced" style="gap:8px;">
                        <x-icon name="receipt" />
                        <span>Lihat Kuitansi Resmi</span>
                    </a>
                @endif
            </aside>
        </div>
    </div>

    <!-- Modal Batalkan Pesanan -->
    <dialog id="cancel-modal">
        <div class="dialog-header">
            <h2>Batalkan Pesanan</h2>
            <button type="button" class="icon-btn" id="btn-close-cancel" aria-label="Tutup dialog">
                <x-icon name="close" />
            </button>
        </div>
        <form action="{{ route('orders.cancel', $order->id_transaksi) }}" method="POST">
            @csrf
            <div class="dialog-body">
                <p>Apakah Anda yakin ingin membatalkan pesanan <strong>{{ $order->kode_booking }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="field">
                    <label for="alasan_batal">Alasan Pembatalan *</label>
                    <textarea id="alasan_batal" name="alasan_batal" rows="3" required placeholder="Contoh: Perubahan jadwal rencana perjalanan..."></textarea>
                </div>
                <div class="button-row">
                    <button type="button" class="btn btn-outline" id="btn-cancel-dismiss">Kembali</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                </div>
            </div>
        </form>
    </dialog>

    @push('scripts')
    <script>
        const cancelModal = document.getElementById('cancel-modal');
        const openBtn = document.getElementById('btn-open-cancel');
        const closeBtn = document.getElementById('btn-close-cancel');
        const dismissBtn = document.getElementById('btn-cancel-dismiss');

        if (openBtn && cancelModal) {
            openBtn.addEventListener('click', () => cancelModal.showModal());
            closeBtn?.addEventListener('click', () => cancelModal.close());
            dismissBtn?.addEventListener('click', () => cancelModal.close());
        }
    </script>
    @endpush
</x-layouts.app>
