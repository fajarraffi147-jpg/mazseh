<x-layouts.app title="Tentang Kami | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Tentang MAZSEH</span>
            </div>
            <div class="page-title">
                <h1>Tentang MAZSEH</h1>
                <p>Manajemen Armada, Zona Sewa, & E-Rental Handal.</p>
            </div>
        </div>

        <section class="story-hero">
            <div class="eyebrow" style="color:#ffad70">Lebih dekat dengan MAZSEH</div>
            <h1>Mobilitas yang tertata.<br>Perjalanan yang bermakna.</h1>
            <p>MAZSEH adalah Manajemen Armada, Zona Sewa, & E-Rental Handal. Kami merancang pengalaman rental yang menyatukan kemudahan penyewa dalam memilih unit dengan pengelolaan operasional yang profesional dan akurat.</p>
        </section>

        <div class="values-list">
            <div>
                <x-icon name="user" style="--od-icon-size:24px; color:var(--blue);" />
                <h3 style="margin-top:12px;">Untuk Penyewa</h3>
                <p>Pilih mobil yang terawat, tentukan jadwal fleksibel, nikmati rincian biaya transparan sejak awal, dan pantau status pesanan langsung dari akun Anda.</p>
            </div>
            <div>
                <x-icon name="shield" style="--od-icon-size:24px; color:var(--green);" />
                <h3 style="margin-top:12px;">Keamanan & Integritas</h3>
                <p>Verifikasi identitas KTP dan SIM yang tertib menjamin keamanan unit dan ketenangan perjalanan Anda di setiap kilometer.</p>
            </div>
            <div>
                <x-icon name="spark" style="--od-icon-size:24px; color:var(--orange);" />
                <h3 style="margin-top:12px;">Teknologi Cerdas</h3>
                <p>Didukung asisten AI 24/7 untuk konsultasi rekomendasi armada dan integrasi WhatsApp instan dengan staf customer service kami.</p>
            </div>
        </div>

        <div class="contact-banner section-small">
            <div>
                <h2>Mulai dari pilihan mobil yang tepat.</h2>
                <p>Jelajahi katalog armada kami dan temukan kendaraan terbaik untuk perjalanan Anda berikutnya.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                <span>Lihat Pilihan Mobil</span>
                <x-icon name="arrow" />
            </a>
        </div>
    </div>
</x-layouts.app>
