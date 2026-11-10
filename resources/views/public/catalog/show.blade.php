<x-layouts.app :title="$car->merk_model . ' | Sewa Mobil MAZSEH'">
    @php
        $startDate = \Carbon\Carbon::parse($start);
        $endDate = \Carbon\Carbon::parse($end);
        $days = max(1, $startDate->diffInDays($endDate));
        $estimateTotal = (float) $car->harga_sewa * $days;
        $isAvailable = $car->isAvailableForDates($start, $end);
        $isMaintenance = $car->status_ketersediaan === 'maintenance';
    @endphp

    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <a href="{{ route('catalog.index') }}">Sewa Mobil</a>
                <x-icon name="chevron" />
                <span>{{ $car->merk_model }}</span>
            </div>
            <div class="page-title">
                <h1>{{ $car->merk_model }}</h1>
                <p>Ruang nyaman dan performa prima untuk setiap rencana perjalanan Anda.</p>
            </div>
        </div>

        <div class="two-col section-small">
            <!-- Left Info Column -->
            <div>
                <div class="detail-media">
                    <img src="{{ asset($car->foto_mobil ?? 'assets/avanza.png') }}" width="600" height="400" alt="{{ $car->merk_model }}">
                </div>

                <div class="detail-caption">
                    <div>
                        <h2>{{ $car->merk_model }}</h2>
                        <p class="small">{{ $car->kategori->nama_kategori ?? 'Armada' }} &bull; {{ $car->tahun }} &bull; {{ $car->kota }}</p>
                    </div>
                </div>

                <div class="spec-grid">
                    <div class="spec-item">
                        <x-icon name="gear" />
                        <strong>{{ $car->transmisi }}</strong>
                        <span>Transmisi</span>
                    </div>
                    <div class="spec-item">
                        <x-icon name="users" />
                        <strong>{{ $car->jumlah_kursi }} kursi</strong>
                        <span>Penumpang</span>
                    </div>
                    <div class="spec-item">
                        <x-icon name="fuel" />
                        <strong>{{ $car->bahan_bakar }}</strong>
                        <span>Bahan bakar</span>
                    </div>
                    <div class="spec-item">
                        <x-icon name="pin" />
                        <strong>{{ $car->kota }}</strong>
                        <span>Lokasi unit</span>
                    </div>
                </div>

                <div class="section-small">
                    <h3>Tentang mobil ini</h3>
                    <p class="spaced small">{{ $car->deskripsi }}</p>

                    @if(!empty($car->fitur))
                        <ul class="feature-list" style="margin-top:20px;">
                            @foreach($car->fitur as $feature)
                                <li>
                                    <x-icon name="check" />
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="panel">
                    <h3>Yang perlu disiapkan</h3>
                    <p class="panel-subtitle">KTP dan SIM A yang masih berlaku, data kontak aktif, serta konfirmasi jadwal. Dokumen akan diverifikasi sebelum unit diserahterimakan.</p>
                    <a href="{{ route('terms') }}" class="text-link" style="margin-top:12px;">Baca syarat & ketentuan sewa</a>
                </div>
            </div>

            <!-- Right Sticky Booking Panel -->
            <aside class="panel sticky-panel">
                <span class="price-label">Tarif sewa /hari</span>
                <div class="price" style="font-size:32px">{{ $car->formatted_price }}<small> /hari</small></div>
                <hr class="rule">

                <form action="{{ route('catalog.show', ['slug' => $car->slug]) }}" method="GET">
                    <div class="form-grid">
                        <div class="field">
                            <label for="detail-start">Tanggal ambil</label>
                            <input id="detail-start" name="start" type="date" value="{{ $start }}" min="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="field">
                            <label for="detail-end">Tanggal kembali</label>
                            <input id="detail-end" name="end" type="date" value="{{ $end }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline wfull" style="margin-bottom:16px;">Periksa Jadwal</button>
                </form>

                <div class="summary-line spaced">
                    <span>Durasi sewa</span>
                    <strong>{{ $days }} hari</strong>
                </div>
                <div class="summary-line summary-total">
                    <span>Estimasi total</span>
                    <strong>Rp{{ number_format($estimateTotal, 0, ',', '.') }}</strong>
                </div>

                <div class="spaced">
                    @if($isAvailable && !$isMaintenance)
                        <div class="notice success">
                            <x-icon name="check" />
                            <span>Mobil tersedia pada rentang tanggal pilihan Anda.</span>
                        </div>
                    @elseif($isMaintenance)
                        <div class="notice warning">
                            <x-icon name="wrench" />
                            <span>Unit sedang dalam masa perawatan rutin. Silakan pilih unit lain.</span>
                        </div>
                    @else
                        <div class="notice warning">
                            <x-icon name="clock" />
                            <span>Mobil sudah dipesan pada sebagian rentang tanggal ini. Coba jadwal lain.</span>
                        </div>
                    @endif
                </div>

                <div style="margin-top:20px;">
                    @if($isAvailable && !$isMaintenance)
                        <a href="{{ route('checkout.create', ['slug' => $car->slug, 'start' => $start, 'end' => $end]) }}" class="btn btn-primary wfull" style="gap:8px;">
                            <span>Sewa Mobil Ini</span>
                            <x-icon name="arrow" />
                        </a>
                    @else
                        <button type="button" class="btn btn-primary wfull" disabled>
                            <span>Unit Tidak Tersedia</span>
                        </button>
                    @endif
                </div>

                <p class="tiny muted spaced">Bahan bakar, tol, parkir, dan layanan sopir opsional dapat disesuaikan pada langkah berikutnya.</p>
            </aside>
        </div>
    </div>
</x-layouts.app>
