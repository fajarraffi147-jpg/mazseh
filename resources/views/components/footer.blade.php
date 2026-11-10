<footer class="site-footer">
    <div class="container">
        <div class="footer-main">
            <div>
                <a class="brand" href="{{ route('home') }}">
                    <div>
                        <span class="brand-name">MAZ<span>SEH</span></span>
                        <span class="brand-caption">YOUR JOURNEY, OUR DRIVE</span>
                    </div>
                </a>
                <p>Manajemen Armada, Zona Sewa, & E-Rental Handal. Temukan mobil yang tepat untuk setiap rencana perjalanan Anda dengan mudah, aman, dan transparan.</p>
            </div>
            <div class="footer-links">
                <h4>Perjalanan Anda</h4>
                <a href="{{ route('catalog.index') }}">Pilihan mobil</a>
                <a href="{{ route('orders.index') }}">Pesanan saya</a>
                <a href="{{ route('about') }}">Tentang MAZSEH</a>
            </div>
            <div class="footer-links">
                <h4>Informasi</h4>
                <a href="{{ route('contact') }}">Hubungi kami</a>
                <a href="{{ route('terms') }}">Ketentuan sewa</a>
                <a href="{{ route('privacy') }}">Kebijakan privasi</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} MAZSEH. Dirancang untuk perjalanan Anda.</span>
            <span>Armada terpercaya &bull; Tarif transparan &bull; Layanan prima</span>
        </div>
    </div>
</footer>
