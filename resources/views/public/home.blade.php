<x-layouts.app title="MAZSEH | Sewa Mobil untuk Setiap Perjalanan">
    <div class="container hero-wrap">
        <section class="hero">
            <div class="hero-copy">
                <div class="eyebrow">Setiap perjalanan punya cerita</div>
                <h1>Tujuan Anda.<br>Mobilnya, <span>MAZSEH.</span></h1>
                <p>Dari urusan kerja hingga waktu bersama keluarga. Pilih mobil yang pas, atur jadwal, dan mulai perjalanan Anda dengan tenang.</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                    <span>Temukan Mobil Anda</span>
                    <x-icon name="arrow" />
                </a>
                <div class="hero-footnote">
                    <x-icon name="check" /> Pilihan mobil & rincian biaya dalam satu tempat
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-word" aria-hidden="true">FORTUNER</div>
                <img src="{{ asset('assets/fortuner.png') }}" width="600" height="400" alt="Toyota Fortuner, SUV tangguh pilihan MAZSEH" fetchpriority="high">
                <div class="hero-car-label">
                    <span><strong>Toyota Fortuner</strong>SUV &bull; 7 penumpang</span>
                    <span>Lebih banyak ruang.<br>Lebih banyak cerita.</span>
                </div>
            </div>
        </section>

        <!-- Booking Console Form -->
        <form action="{{ route('catalog.index') }}" method="GET">
            <div class="booking-console">
                <div class="console-field">
                    <div class="console-label">
                        <x-icon name="pin" />
                        <label for="home-city">Lokasi pengambilan</label>
                    </div>
                    <select id="home-city" name="city">
                        <option value="Semua kota">Semua kota</option>
                        <option value="Semarang" {{ request('city') === 'Semarang' ? 'selected' : '' }}>Semarang</option>
                        <option value="Jakarta" {{ request('city') === 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                        <option value="Bandung" {{ request('city') === 'Bandung' ? 'selected' : '' }}>Bandung</option>
                        <option value="Surabaya" {{ request('city') === 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                    </select>
                </div>

                <div class="console-field">
                    <div class="console-label">
                        <x-icon name="car" />
                        <label for="home-category">Jenis mobil</label>
                    </div>
                    <select id="home-category" name="category">
                        <option value="Semua">Semua</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->nama_kategori }}" {{ request('category') === $cat->nama_kategori ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="console-dates">
                    <div>
                        <div class="console-label">
                            <x-icon name="calendar" />
                            <label for="home-start">Tanggal ambil</label>
                        </div>
                        <input id="home-start" name="start" type="date" value="{{ request('start', now()->addDay()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div>
                        <div class="console-label">
                            <label for="home-end">Tanggal kembali</label>
                        </div>
                        <input id="home-end" name="end" type="date" value="{{ request('end', now()->addDays(3)->format('Y-m-d')) }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="gap:8px;">
                    <x-icon name="search" />
                    <span>Cari Mobil</span>
                </button>
            </div>
        </form>

        <!-- Advantages Grid -->
        <div class="advantages">
            <div class="advantage">
                <x-icon name="car" />
                <div>
                    <strong>Pilihan untuk setiap kebutuhan</strong>
                    <span>Dari city car lincah hingga SUV premium</span>
                </div>
            </div>
            <div class="advantage">
                <x-icon name="receipt" />
                <div>
                    <strong>Biaya terlihat sejak awal</strong>
                    <span>Rincian sewa transparan tanpa biaya tersembunyi</span>
                </div>
            </div>
            <div class="advantage">
                <x-icon name="calendar" />
                <div>
                    <strong>Jadwal sesuai rencana</strong>
                    <span>Cari ketersediaan mobil langsung berdasarkan tanggal Anda</span>
                </div>
            </div>
        </div>

        <!-- Featured Cars Section -->
        <section class="section">
            <div class="section-head">
                <div>
                    <div class="eyebrow">Temukan teman perjalanan</div>
                    <h2>Mobil yang pas untuk Anda</h2>
                    <p>Sesuaikan pilihan dengan tujuan dan kebutuhan perjalanan Anda.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-link">
                    <span>Lihat semua mobil</span>
                    <x-icon name="arrow" />
                </a>
            </div>

            <div class="category-tabs" aria-label="Kategori mobil">
                <a href="{{ route('home') }}" class="chip {{ !request('category') || request('category') === 'Semua' ? 'active' : '' }}">
                    <x-icon name="car" />
                    <span>Semua mobil</span>
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->nama_kategori]) }}" class="chip {{ request('category') === $cat->nama_kategori ? 'active' : '' }}">
                        <span>{{ $cat->nama_kategori }}</span>
                    </a>
                @endforeach
            </div>

            <div class="car-grid">
                @forelse($cars as $car)
                    <x-car-card :car="$car" />
                @empty
                    <div class="empty-state">
                        <x-icon name="search" />
                        <h3>Kategori belum memiliki mobil</h3>
                        <p>Pilih kategori lain untuk melihat armada kami.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="how-section section">
            <div class="container how-layout">
                <div>
                    <div class="eyebrow">Sederhana dari awal</div>
                    <h2>Rencana jalan?<br>Mulai dari sini.</h2>
                    <p class="small">Atur perjalanan tanpa melewatkan detail penting dengan 3 langkah mudah.</p>
                </div>
                <div class="steps-grid">
                    <div>
                        <span class="step-number">01 / PILIH</span>
                        <h3>Temukan mobil Anda</h3>
                        <p>Tentukan lokasi, tanggal, dan kendaraan yang sesuai dengan jumlah penumpang dan rute perjalanan.</p>
                    </div>
                    <div>
                        <span class="step-number">02 / PESAN</span>
                        <h3>Lengkapi detail sewa</h3>
                        <p>Tentukan opsi pengemudi, unggah dokumen identitas KTP & SIM, dan tinjau rincian biaya.</p>
                    </div>
                    <div>
                        <span class="step-number">03 / BERANGKAT</span>
                        <h3>Konfirmasi & ambil mobil</h3>
                        <p>Selesaikan pembayaran aman, lakukan serah-terima unit di pool atau antar ke lokasi Anda, lalu nikmati perjalanan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Banner -->
        <div class="section">
            <div class="contact-banner">
                <div>
                    <h2>Ada rencana, tapi belum yakin pilih mobil yang mana?</h2>
                    <p>Konsultasikan kebutuhan perjalanan Anda dengan tim kami atau tanyakan langsung ke Asisten AI MAZSEH.</p>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-dark">
                    <span>Hubungi MAZSEH</span>
                    <x-icon name="arrow" />
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
