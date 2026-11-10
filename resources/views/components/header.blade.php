<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="{{ route('home') }}">
            <div>
                <span class="brand-name">MAZ<span>SEH</span></span>
                <span class="brand-caption">YOUR JOURNEY, OUR DRIVE</span>
            </div>
        </a>

        <nav class="public-nav" id="main-nav" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Sewa Mobil</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
            @auth
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">Pesanan Saya</a>
            @else
                <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Akun Saya</a>
            @endauth
        </nav>

        <div class="header-actions">
            @auth
                <a href="{{ route('profile.edit') }}" class="btn btn-outline" style="gap:8px;">
                    <x-icon name="user" />
                    <span>{{ Str::words(Auth::user()->name, 1, '') }}</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="icon-btn" aria-label="Keluar akun" title="Keluar">
                        <x-icon name="logout" />
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-dark register-button">Daftar</a>
            @endauth

            <button type="button" class="icon-btn mobile-menu-button" id="menu-toggle" aria-label="Buka menu navigasi" aria-expanded="false">
                <x-icon name="menu" id="menu-icon" />
            </button>
        </div>
    </div>
</header>
