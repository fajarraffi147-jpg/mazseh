<x-layouts.app title="Profil Saya | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Profil saya</span>
            </div>
            <div class="page-title">
                <h1>Profil saya</h1>
                <p>Kelola informasi akun, alamat penjemputan, dan verifikasi dokumen identitas.</p>
            </div>
        </div>

        <div class="two-col section-small">
            <!-- Left Profile & Document Form -->
            <div class="panel">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h2 style="font-size:20px; margin-bottom:16px;">Data Pribadi</h2>
                    <div class="form-grid">
                        <div class="field">
                            <label for="name">Nama lengkap *</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="80">
                        </div>
                        <div class="field">
                            <label for="email">Alamat email *</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="field">
                            <label for="phone">Nomor telepon / WhatsApp *</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                        <div class="field">
                            <label for="city">Kota domisili</label>
                            <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}" placeholder="Contoh: Semarang">
                        </div>
                        <div class="field full">
                            <label for="address">Alamat lengkap penjemputan</label>
                            <textarea id="address" name="address" rows="2" placeholder="Nama jalan, nomor rumah, kelurahan, kecamatan...">{{ old('address', $user->address) }}</textarea>
                        </div>
                        <div class="field full">
                            <label for="sim_number">Nomor SIM A</label>
                            <input id="sim_number" name="sim_number" type="text" value="{{ old('sim_number', $user->sim_number) }}" placeholder="Contoh: 1234-5678-901234">
                        </div>
                    </div>

                    <hr class="rule">

                    <!-- Document Verification Section -->
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                        <div>
                            <h2 style="font-size:20px;">Dokumen Identitas (KTP & SIM)</h2>
                            <p class="small muted">Dokumen terverifikasi mempercepat proses pengambilan mobil saat sewa.</p>
                        </div>
                        @if($document)
                            <span class="badge {{ $document->status_badge_class }}" style="font-size:12px; padding:6px 12px;">
                                {{ $document->status_label }}
                            </span>
                        @else
                            <span class="badge gray" style="font-size:12px; padding:6px 12px;">Belum Upload</span>
                        @endif
                    </div>

                    <div class="form-grid">
                        <div class="field">
                            <label for="file_ktp">Foto KTP Asli</label>
                            <div class="doc-upload-box">
                                <input type="file" id="file_ktp" name="file_ktp" accept="image/*">
                                <span class="hint" style="margin-top:6px; display:block;">Pilih gambar baru untuk memperbarui KTP</span>
                                @if($document && $document->file_ktp)
                                    <div style="margin-top:10px;">
                                        <small class="muted">File KTP tersimpan</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label for="file_sim">Foto SIM A Asli</label>
                            <div class="doc-upload-box">
                                <input type="file" id="file_sim" name="file_sim" accept="image/*">
                                <span class="hint" style="margin-top:6px; display:block;">Pilih gambar baru untuk memperbarui SIM</span>
                                @if($document && $document->file_sim)
                                    <div style="margin-top:10px;">
                                        <small class="muted">File SIM tersimpan</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="button-row" style="margin-top:24px;">
                        <button type="submit" class="btn btn-primary" style="padding-inline:28px;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- Right Profile Summary -->
            <aside class="panel">
                <div class="od-row gap16">
                    <span class="avatar" style="width:48px; height:48px; font-size:16px;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </span>
                    <div>
                        <h3 style="font-size:18px;">{{ $user->name }}</h3>
                        <p class="small">{{ ucfirst($user->role) }} MAZSEH</p>
                    </div>
                </div>

                <div class="spaced">
                    <div class="summary-line">
                        <span>Total Pesanan</span>
                        <strong>{{ $user->transaksi()->count() }} pesanan</strong>
                    </div>
                    <div class="summary-line">
                        <span>Bergabung Sejak</span>
                        <strong>{{ $user->created_at ? $user->created_at->translatedFormat('M Y') : '2026' }}</strong>
                    </div>
                </div>

                <div class="spaced">
                    <div class="notice">
                        <x-icon name="shield" />
                        <span>Data pribadi Anda terenkripsi aman dan hanya digunakan untuk keperluan verifikasi sewa armada MAZSEH.</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin-top:24px;">
                    @csrf
                    <button type="submit" class="btn btn-outline wfull" style="gap:8px;">
                        <x-icon name="logout" />
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </aside>
        </div>
    </div>
</x-layouts.app>
