<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <meta name="description" content="MAZSEH - Manajemen Armada, Zona Sewa, & E-Rental Handal. Sewa mobil untuk setiap kebutuhan perjalanan Anda.">
    <title>{{ $title ?? 'MAZSEH | Sewa Mobil untuk Setiap Perjalanan' }}</title>

    <link rel="preload" href="{{ asset('assets/inter-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/mazseh.css') }}">
    @stack('styles')
</head>
<body>
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <x-header />

    @if(session('success'))
        <div class="container" style="padding-top:20px;">
            <div class="notice success">
                <x-icon name="check" />
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container" style="padding-top:20px;">
            <div class="notice error">
                <x-icon name="info" />
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <main id="main">
        {{ $slot }}
    </main>

    <x-footer />

    <x-ai-chatbot />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('menu-toggle');
            const mainNav = document.getElementById('main-nav');
            if (menuBtn && mainNav) {
                menuBtn.addEventListener('click', function() {
                    const isOpen = mainNav.classList.toggle('is-open');
                    menuBtn.setAttribute('aria-expanded', isOpen);
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
