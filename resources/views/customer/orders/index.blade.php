<x-layouts.app title="Pesanan Saya | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Pesanan saya</span>
            </div>
            <div class="page-title">
                <h1>Pesanan saya</h1>
                <p>Semua perjalanan Anda bersama armada MAZSEH, dari rencana hingga selesai.</p>
            </div>
        </div>

        <!-- Filter Status Chips -->
        <div class="category-tabs">
            <a href="{{ route('orders.index') }}" class="chip {{ !request('status') || request('status') === 'Semua' ? 'active' : '' }}">
                <span>Semua</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'menunggu_pembayaran']) }}" class="chip {{ request('status') === 'menunggu_pembayaran' ? 'active' : '' }}">
                <span>Menunggu Pembayaran</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'dikonfirmasi']) }}" class="chip {{ request('status') === 'dikonfirmasi' ? 'active' : '' }}">
                <span>Dikonfirmasi</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'dibatalkan']) }}" class="chip {{ request('status') === 'dibatalkan' ? 'active' : '' }}">
                <span>Dibatalkan</span>
            </a>
        </div>

        <div class="order-grid section-small">
            @forelse($orders as $order)
                <article class="order-card">
                    <div class="order-card-top">
                        <span><strong>{{ $order->kode_booking }}</strong> &bull; Dipesan pada {{ $order->waktu_pesan ? $order->waktu_pesan->translatedFormat('d M Y, H:i') : '-' }} WIB</span>
                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                    </div>
                    <div class="order-card-content">
                        <img src="{{ asset($order->mobil->foto_mobil ?? 'assets/avanza.png') }}" width="120" height="80" alt="{{ $order->mobil->merk_model }}" style="object-fit:cover;">
                        <div>
                            <h3>{{ $order->mobil->merk_model }}</h3>
                            <p>{{ $order->tanggal_mulai->translatedFormat('d M Y') }} &ndash; {{ $order->tanggal_selesai->translatedFormat('d M Y') }} &bull; {{ $order->duration_days }} hari</p>
                            <p><x-icon name="pin" style="--od-icon-size:14px;" /> {{ $order->titik_jemput }} &bull; {{ $order->opsi_pengemudi }}</p>
                        </div>
                        <div class="order-actions">
                            <div class="price">{{ $order->formatted_total }}</div>
                            <a href="{{ route('orders.show', $order->id_transaksi) }}" class="text-link">
                                <span>Detail Pesanan</span>
                                <x-icon name="chevron" />
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <x-icon name="search" />
                    <h3>Belum ada pesanan di sini</h3>
                    <p>Pilih mobil yang sesuai dan mulai rencana perjalanan Anda bersama MAZSEH.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="margin-top:12px;">Cari Mobil</a>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
