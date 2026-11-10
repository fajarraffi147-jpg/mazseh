<x-layouts.app title="Daftar Akun | MAZSEH">
    <div class="auth-wrap">
        <section class="auth-story">
            <div class="eyebrow" style="color:#ffad70">Perjalanan dimulai di sini</div>
            <h1>Satu akun.<br>Banyak tujuan.</h1>
            <p>Daftar sekarang untuk kemudahan pemesanan sewa mobil, upload verifikasi dokumen sekali jalan, dan nikmati diskon khusus member.</p>
            <img src="{{ asset('assets/zenix.png') }}" width="600" height="400" alt="Toyota Innova Zenix">
        </section>

        <section class="auth-form-wrap">
            <div class="auth-form">
                <h1 tabindex="-1">Buat akun MAZSEH</h1>
                <p>Lengkapi formulir singkat berikut untuk mulai menyewa mobil pilihan Anda.</p>

                @if($errors->any())
                    <div class="notice error error-summary" style="margin-bottom:20px;">
                        <x-icon name="info" />
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label for="name">Nama lengkap *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="80" autocomplete="name" placeholder="Nama Anda">
                    </div>

                    <div class="field">
                        <label for="email">Alamat email *</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                    </div>

                    <div class="field">
                        <label for="phone">Nomor telepon / WhatsApp *</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi *</label>
                        <input id="password" name="password" type="password" required minlength="6" placeholder="Minimal 6 karakter">
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi kata sandi *</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required minlength="6" placeholder="Ulangi kata sandi">
                    </div>

                    <label class="check-label">
                        <input type="checkbox" name="consent" required checked>
                        <span>Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-link" style="min-height:auto;">syarat & ketentuan</a> serta <a href="{{ route('privacy') }}" target="_blank" class="text-link" style="min-height:auto;">kebijakan privasi</a> MAZSEH.</span>
                    </label>

                    <button type="submit" class="btn btn-primary wfull" style="margin-top:16px;">Buat Akun</button>
                </form>

                <p class="small text-center spaced">
                    Sudah memiliki akun? <a href="{{ route('login') }}" class="text-link" style="min-height:auto;">Masuk sekarang</a>
                </p>
            </div>
        </section>
    </div>
</x-layouts.app>
