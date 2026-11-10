<x-layouts.app title="Masuk Akun | MAZSEH">
    <div class="auth-wrap">
        <section class="auth-story">
            <div class="eyebrow" style="color:#ffad70">Perjalanan dimulai di sini</div>
            <h1>Satu akun.<br>Banyak tujuan.</h1>
            <p>Simpan rencana sewa, pantau status pesanan, dan kelola perjalanan Anda bersama armada terbaik MAZSEH.</p>
            <img src="{{ asset('assets/zenix.png') }}" width="600" height="400" alt="Toyota Innova Zenix">
        </section>

        <section class="auth-form-wrap">
            <div class="auth-form">
                <h1 tabindex="-1">Selamat datang kembali</h1>
                <p>Masuk ke akun Anda untuk melanjutkan proses sewa atau memantau pesanan.</p>

                @if($errors->any())
                    <div class="notice error error-summary" style="margin-bottom:20px;">
                        <x-icon name="info" />
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label for="email">Alamat email *</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi *</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
                    </div>

                    <div class="od-row" style="justify-content:flex-end; margin-bottom:16px;">
                        <a href="{{ route('forgot-password') }}" class="text-link" style="min-height:auto;">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="btn btn-primary wfull" style="margin-top:8px;">Masuk</button>
                </form>

                <p class="small text-center spaced">
                    Belum memiliki akun? <a href="{{ route('register') }}" class="text-link" style="min-height:auto;">Daftar sekarang</a>
                </p>

                <!-- Demo Accounts Quick Fill -->
                <div class="demo-accounts">
                    <p><strong>Coba dengan akun demo</strong><br>Klik salah satu akun di bawah untuk mengisi formulir secara otomatis:</p>
                    <div class="od-cluster">
                        <button type="button" class="btn btn-outline btn-small demo-btn" data-email="pelanggan@mazseh.demo" data-pass="mazseh123">Pelanggan</button>
                        <button type="button" class="btn btn-outline btn-small demo-btn" data-email="kasir@mazseh.demo" data-pass="mazseh123">Kasir</button>
                        <button type="button" class="btn btn-outline btn-small demo-btn" data-email="admin@mazseh.demo" data-pass="mazseh123">Admin</button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.demo-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('email').value = this.dataset.email;
                document.getElementById('password').value = this.dataset.pass;
            });
        });
    </script>
    @endpush
</x-layouts.app>
