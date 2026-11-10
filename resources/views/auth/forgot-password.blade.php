<x-layouts.app title="Lupa Kata Sandi | MAZSEH">
    <div class="auth-wrap">
        <section class="auth-story">
            <div class="eyebrow" style="color:#ffad70">Pemulihan Akun</div>
            <h1>Akses mudah ke akun Anda.</h1>
            <p>Masukkan alamat email terdaftar Anda untuk menerima tautan pemulihan kata sandi akun MAZSEH.</p>
            <img src="{{ asset('assets/zenix.png') }}" width="600" height="400" alt="Toyota Innova Zenix">
        </section>

        <section class="auth-form-wrap">
            <div class="auth-form">
                <h1 tabindex="-1">Lupa kata sandi?</h1>
                <p>Masukkan email akun Anda untuk mendapatkan instruksi pemulihan kata sandi.</p>

                @if(session('status'))
                    <div class="notice success" style="margin-bottom:20px;">
                        <x-icon name="check" />
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="notice error error-summary" style="margin-bottom:20px;">
                        <x-icon name="info" />
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('forgot-password.post') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label for="email">Alamat email *</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                    </div>

                    <button type="submit" class="btn btn-primary wfull" style="margin-top:16px;">Kirim Tautan Pemulihan</button>
                </form>

                <p class="small text-center spaced">
                    Ingat kata sandi Anda? <a href="{{ route('login') }}" class="text-link" style="min-height:auto;">Kembali ke halaman masuk</a>
                </p>
            </div>
        </section>
    </div>
</x-layouts.app>
