<x-layouts.app title="Katalog Mobil & Filter Sewa | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Pilihan mobil, mulai perjalanan.</span>
            </div>
            <div class="page-title">
                <h1>Pilih mobil, mulai perjalanan.</h1>
                <p>Temukan armada yang sesuai dengan rencana dan kebutuhan Anda.</p>
            </div>
        </div>

        <div class="catalog-layout">
            <!-- Filter Sidebar -->
            <aside class="panel filter-panel">
                <div class="od-row" style="justify-content:space-between; margin-bottom:16px;">
                    <h3>Filter pencarian</h3>
                    <a href="{{ route('catalog.index') }}" class="text-link" style="min-height:auto;">Reset</a>
                </div>

                <form action="{{ route('catalog.index') }}" method="GET">
                    <div class="filter-fields">
                        <div class="field">
                            <label for="filter-query">Cari mobil</label>
                            <div class="search-field">
                                <x-icon name="search" />
                                <input id="filter-query" name="query" type="search" value="{{ request('query') }}" placeholder="Nama mobil...">
                            </div>
                        </div>

                        <div class="field">
                            <label for="filter-city">Kota pengambilan</label>
                            <select id="filter-city" name="city">
                                <option value="Semua kota">Semua kota</option>
                                <option value="Semarang" {{ request('city') === 'Semarang' ? 'selected' : '' }}>Semarang</option>
                                <option value="Jakarta" {{ request('city') === 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                                <option value="Bandung" {{ request('city') === 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                <option value="Surabaya" {{ request('city') === 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="filter-category">Kategori</label>
                            <select id="filter-category" name="category">
                                <option value="Semua">Semua</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->nama_kategori }}" {{ request('category') === $cat->nama_kategori ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="filter-start">Tanggal ambil</label>
                            <input id="filter-start" name="start" type="date" value="{{ $start }}" min="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <div class="field">
                            <label for="filter-end">Tanggal kembali</label>
                            <input id="filter-end" name="end" type="date" value="{{ $end }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                        </div>

                        <div class="field">
                            <label for="filter-transmission">Transmisi</label>
                            <select id="filter-transmission" name="transmission">
                                <option value="Semua">Semua</option>
                                <option value="Otomatis" {{ request('transmission') === 'Otomatis' ? 'selected' : '' }}>Otomatis</option>
                                <option value="Manual" {{ request('transmission') === 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="filter-max">Maksimum tarif /hari</label>
                            <input id="filter-max" name="max" type="number" min="0" step="50000" value="{{ request('max') }}" placeholder="Tanpa batas">
                        </div>

                        <input type="hidden" name="sort" value="{{ request('sort', 'Pilihan MAZSEH') }}">
                    </div>

                    <button type="submit" class="btn btn-dark wfull" style="gap:8px; margin-top:8px;">
                        <x-icon name="search" />
                        <span>Terapkan Filter</span>
                    </button>
                </form>
            </aside>

            <!-- Car Grid & Toolbar -->
            <div>
                <div class="catalog-toolbar">
                    <span>
                        <strong>{{ $cars->count() }} mobil</strong> <span class="muted">ditemukan</span><br>
                        <small class="muted">{{ \Carbon\Carbon::parse($start)->translatedFormat('d M Y') }} &ndash; {{ \Carbon\Carbon::parse($end)->translatedFormat('d M Y') }}</small>
                    </span>

                    <form id="sort-form" action="{{ route('catalog.index') }}" method="GET" style="display:inline-flex;">
                        @foreach(request()->except('sort') as $key => $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endforeach
                        <select aria-label="Urutkan mobil" name="sort" onchange="document.getElementById('sort-form').submit()">
                            <option value="Pilihan MAZSEH" {{ request('sort') === 'Pilihan MAZSEH' ? 'selected' : '' }}>Pilihan MAZSEH</option>
                            <option value="Harga terendah" {{ request('sort') === 'Harga terendah' ? 'selected' : '' }}>Harga terendah</option>
                            <option value="Harga tertinggi" {{ request('sort') === 'Harga tertinggi' ? 'selected' : '' }}>Harga tertinggi</option>
                        </select>
                    </form>
                </div>

                <div class="car-grid">
                    @forelse($cars as $car)
                        <x-car-card :car="$car" :start="$start" :end="$end" />
                    @empty
                        <div class="empty-state">
                            <x-icon name="search" />
                            <h3>Mobil belum ditemukan</h3>
                            <p>Coba ubah nama, kota, kategori, atau batas tarif pencarian Anda.</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-dark" style="margin-top:12px;">Reset Filter</a>
                        </div>
                    @endforelse
                </div>

                <p class="data-note">Ketersediaan dihitung langsung dari kalender jadwal pesanan sistem. Spesifikasi dan tarif merupakan konfigurasi resmi armada MAZSEH.</p>
            </div>
        </div>
    </div>
</x-layouts.app>
