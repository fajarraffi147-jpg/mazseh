<x-layouts.app :title="'Checkout Sewa ' . $car->merk_model . ' | MAZSEH'">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <a href="{{ route('catalog.show', $car->slug) }}">{{ $car->merk_model }}</a>
                <x-icon name="chevron" />
                <span>Lengkapi rencana perjalanan</span>
            </div>
            <div class="page-title">
                <h1>Lengkapi rencana perjalanan</h1>
                <p>Periksa detail jadwal, titik penjemputan, dan dokumen identitas Anda.</p>
            </div>
        </div>

        <ol class="stepper" id="checkout-stepper">
            <li class="active" id="step-tab-1"><b>1</b><span>Jadwal & Lokasi</span></li>
            <li id="step-tab-2"><b>2</b><span>Data & Dokumen</span></li>
            <li id="step-tab-3"><b>3</b><span>Konfirmasi</span></li>
        </ol>

        @if($errors->any())
            <div class="notice error error-summary" style="margin-bottom:24px;">
                <x-icon name="info" />
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="two-col section-small">
            <div class="panel">
                <form id="checkout-form" action="{{ route('checkout.store', $car->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- STEP 1: JADWAL & LOKASI -->
                    <div id="step-1" class="checkout-step-panel">
                        <h2 style="font-size:22px; margin-bottom:8px;">1. Jadwal & Lokasi Jemput</h2>
                        <p class="panel-subtitle" style="margin-bottom:20px;">Tentukan waktu sewa, opsi sopir, dan alamat serah-terima unit.</p>

                        <div class="form-grid spaced">
                            <div class="field">
                                <label for="start">Tanggal ambil *</label>
                                <input id="start" name="start" type="date" value="{{ old('start', $start) }}" min="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="field">
                                <label for="end">Tanggal kembali *</label>
                                <input id="end" name="end" type="date" value="{{ old('end', $end) }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                            </div>
                            <div class="field">
                                <label for="waktu_ambil">Jam serah-terima *</label>
                                <input id="waktu_ambil" name="waktu_ambil" type="time" value="{{ old('waktu_ambil', '09:00') }}" required>
                            </div>
                            <div class="field">
                                <label for="opsi_pengemudi">Pilihan pengemudi *</label>
                                <select id="opsi_pengemudi" name="opsi_pengemudi">
                                    <option value="Lepas kunci" {{ old('opsi_pengemudi') === 'Lepas kunci' ? 'selected' : '' }}>Lepas kunci</option>
                                    <option value="Dengan sopir" {{ old('opsi_pengemudi') === 'Dengan sopir' ? 'selected' : '' }}>Dengan sopir (+Rp200.000/hari)</option>
                                </select>
                            </div>
                            <div class="field full">
                                <label for="metode_pengambilan">Metode pengambilan unit *</label>
                                <select id="metode_pengambilan" name="metode_pengambilan">
                                    <option value="Ambil di pool MAZSEH" {{ old('metode_pengambilan') === 'Ambil di pool MAZSEH' ? 'selected' : '' }}>Ambil di pool MAZSEH ({{ $car->kota }})</option>
                                    <option value="Antar ke lokasi saya" {{ old('metode_pengambilan') === 'Antar ke lokasi saya' ? 'selected' : '' }}>Antar langsung ke lokasi saya</option>
                                </select>
                            </div>
                            <div class="field full">
                                <label for="titik_jemput">Alamat / Titik jemput *</label>
                                <textarea id="titik_jemput" name="titik_jemput" rows="2" placeholder="Nama jalan, nomor gedung, atau penanda lokasi penjemputan..." required>{{ old('titik_jemput', Auth::user()->address ?? 'Pool MAZSEH ' . $car->kota) }}</textarea>
                            </div>
                        </div>

                        <!-- Titik Koordinat GPS Picker -->
                        <div class="coord-box">
                            <div>
                                <strong>Titik Koordinat GPS (Opsional)</strong>
                                <span class="muted" style="display:block;">Memudahkan driver/staf mengantarkan mobil tepat ke posisi Anda.</span>
                                <div style="display:flex; gap:12px; margin-top:6px;">
                                    <span>Lat: <strong id="lat-display">{{ old('latitude', '-6.974300') }}</strong></span>
                                    <span>Long: <strong id="long-display">{{ old('longitude', '110.418400') }}</strong></span>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline btn-small" id="btn-get-gps" style="gap:6px;">
                                <x-icon name="pin" style="--od-icon-size:16px;" />
                                <span>Gunakan GPS Saya</span>
                            </button>
                        </div>
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', '-6.974300') }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', '110.418400') }}">

                        <div class="button-row" style="margin-top:24px;">
                            <button type="button" class="btn btn-primary" id="btn-to-step-2">
                                <span>Lanjutkan ke Data & Dokumen</span>
                                <x-icon name="arrow" />
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: DATA PENYEWA & UPLOAD DOKUMEN -->
                    <div id="step-2" class="checkout-step-panel" style="display:none;">
                        <h2 style="font-size:22px; margin-bottom:8px;">2. Data Penyewa & Dokumen KTP / SIM</h2>
                        <p class="panel-subtitle" style="margin-bottom:20px;">Sesuai regulasi rental mobil, penyewa wajib melampirkan identitas KTP dan SIM A yang berlaku.</p>

                        <div class="form-grid spaced">
                            <div class="field">
                                <label for="name">Nama lengkap *</label>
                                <input id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                            <div class="field">
                                <label for="email">Alamat email *</label>
                                <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                            <div class="field">
                                <label for="phone">Nomor telepon / WhatsApp *</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone', Auth::user()->phone) }}" required>
                            </div>
                            <div class="field">
                                <label for="sim_number">Nomor SIM A *</label>
                                <input id="sim_number" name="sim_number" type="text" value="{{ old('sim_number', Auth::user()->sim_number) }}" placeholder="Contoh: 1234-5678-901234" required>
                            </div>
                        </div>

                        <!-- Document Upload Grid -->
                        <div style="margin-top:24px;">
                            <label style="font-weight:600; font-size:14px; margin-bottom:12px; display:block;">Unggah Dokumen Identitas (KTP & SIM)</label>

                            @if($document && $document->status_verifikasi === 'disetujui')
                                <div class="notice success" style="margin-bottom:16px;">
                                    <x-icon name="check" />
                                    <span>Dokumen identitas Anda sudah <strong>Terverifikasi & Disetujui</strong> sebelumnya. Anda tidak perlu mengunggah ulang kecuali ingin memperbarui.</span>
                                </div>
                            @endif

                            <div class="form-grid">
                                <div class="field">
                                    <label>Foto KTP Asli @if(!$document) * @endif</label>
                                    <div class="doc-upload-box">
                                        <input type="file" name="file_ktp" id="file_ktp" accept="image/*" @if(!$document) required @endif style="border:0; padding:0; background:transparent;">
                                        <span class="hint" style="margin-top:6px; display:block;">Format JPG, PNG, atau WebP (Maks 3MB)</span>
                                        @if($document && $document->file_ktp)
                                            <div style="margin-top:10px;">
                                                <span class="badge {{ $document->status_badge_class }}">KTP: {{ $document->status_label }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="field">
                                    <label>Foto SIM A Asli @if(!$document) * @endif</label>
                                    <div class="doc-upload-box">
                                        <input type="file" name="file_sim" id="file_sim" accept="image/*" @if(!$document) required @endif style="border:0; padding:0; background:transparent;">
                                        <span class="hint" style="margin-top:6px; display:block;">Format JPG, PNG, atau WebP (Maks 3MB)</span>
                                        @if($document && $document->file_sim)
                                            <div style="margin-top:10px;">
                                                <span class="badge {{ $document->status_badge_class }}">SIM: {{ $document->status_label }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field full" style="margin-top:16px;">
                            <label for="catatan">Catatan / Permintaan Khusus</label>
                            <textarea id="catatan" name="catatan" rows="2" placeholder="Contoh: Tolong siapkan mobil bersih di lobby jam 09.00 tepat.">{{ old('catatan') }}</textarea>
                        </div>

                        <div class="button-row" style="margin-top:24px;">
                            <button type="button" class="btn btn-outline" id="btn-back-to-step-1">
                                <x-icon name="back" />
                                <span>Kembali</span>
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-to-step-3">
                                <span>Lanjutkan ke Konfirmasi</span>
                                <x-icon name="arrow" />
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: KONFIRMASI PESANAN -->
                    <div id="step-3" class="checkout-step-panel" style="display:none;">
                        <h2 style="font-size:22px; margin-bottom:8px;">3. Periksa Kembali Pesanan</h2>
                        <p class="panel-subtitle" style="margin-bottom:20px;">Pastikan data jadwal, penjemputan, dan rincian sewa Anda telah sesuai sebelum mengirim pesanan.</p>

                        <div class="spaced">
                            <div class="summary-line">
                                <span>Penyewa</span>
                                <strong id="conf-name">{{ Auth::user()->name }}</strong>
                            </div>
                            <div class="summary-line">
                                <span>Kontak</span>
                                <strong id="conf-phone">{{ Auth::user()->phone ?? '-' }}</strong>
                            </div>
                            <div class="summary-line">
                                <span>Layanan Sopir</span>
                                <strong id="conf-service">Lepas kunci</strong>
                            </div>
                            <div class="summary-line">
                                <span>Metode & Lokasi Jemput</span>
                                <strong id="conf-pickup">Pool MAZSEH</strong>
                            </div>
                        </div>

                        <hr class="rule">

                        <div class="notice">
                            <x-icon name="info" />
                            <span>Setelah pesanan dibuat, Anda akan diarahkan ke tahap pembayaran instan via Transfer Bank, QRIS, atau Bayar di Kasir.</span>
                        </div>

                        <label class="check-label spaced">
                            <input type="checkbox" name="consent" required checked>
                            <span>Saya telah memeriksa rincian data sewa dan menyetujui ketentuan pemesanan armada MAZSEH.</span>
                        </label>

                        <div class="button-row" style="margin-top:24px;">
                            <button type="button" class="btn btn-outline" id="btn-back-to-step-2">
                                <x-icon name="back" />
                                <span>Kembali</span>
                            </button>
                            <button type="submit" class="btn btn-primary" style="padding-inline:28px;">
                                <span>Kirim Pesanan & Lanjut Bayar</span>
                                <x-icon name="arrow" />
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sticky Booking Summary -->
            <x-booking-summary 
                :car="$car" 
                :start="$start" 
                :end="$end" 
                :time="'09:00'" 
                :service="'Lepas kunci'" 
            />
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const step3 = document.getElementById('step-3');

            const tab1 = document.getElementById('step-tab-1');
            const tab2 = document.getElementById('step-tab-2');
            const tab3 = document.getElementById('step-tab-3');

            // GPS picker
            const btnGps = document.getElementById('btn-get-gps');
            if (btnGps && navigator.geolocation) {
                btnGps.addEventListener('click', function() {
                    btnGps.disabled = true;
                    btnGps.textContent = 'Mendeteksi...';
                    navigator.geolocation.getCurrentPosition(
                        function(pos) {
                            const lat = pos.coords.latitude.toFixed(6);
                            const lng = pos.coords.longitude.toFixed(6);
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                            document.getElementById('lat-display').textContent = lat;
                            document.getElementById('long-display').textContent = lng;
                            btnGps.disabled = false;
                            btnGps.innerHTML = '<svg class="od-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m5 12 4 4L19 6"/></svg> <span>Tersimpan</span>';
                        },
                        function(err) {
                            btnGps.disabled = false;
                            btnGps.textContent = 'GPS Gagal/Ditolak';
                        }
                    );
                });
            }

            // Stepper transitions
            document.getElementById('btn-to-step-2').addEventListener('click', function() {
                step1.style.display = 'none';
                step2.style.display = 'block';
                tab1.classList.remove('active');
                tab2.classList.add('active');
                window.scrollTo({ top: 120, behavior: 'smooth' });
            });

            document.getElementById('btn-back-to-step-1').addEventListener('click', function() {
                step2.style.display = 'none';
                step1.style.display = 'block';
                tab2.classList.remove('active');
                tab1.classList.add('active');
                window.scrollTo({ top: 120, behavior: 'smooth' });
            });

            document.getElementById('btn-to-step-3').addEventListener('click', function() {
                // update confirmation labels
                document.getElementById('conf-name').textContent = document.getElementById('name').value;
                document.getElementById('conf-phone').textContent = document.getElementById('phone').value;
                document.getElementById('conf-service').textContent = document.getElementById('opsi_pengemudi').value;
                document.getElementById('conf-pickup').textContent = document.getElementById('metode_pengambilan').value + ' (' + document.getElementById('titik_jemput').value + ')';

                step2.style.display = 'none';
                step3.style.display = 'block';
                tab2.classList.remove('active');
                tab3.classList.add('active');
                window.scrollTo({ top: 120, behavior: 'smooth' });
            });

            document.getElementById('btn-back-to-step-2').addEventListener('click', function() {
                step3.style.display = 'none';
                step2.style.display = 'block';
                tab3.classList.remove('active');
                tab2.classList.add('active');
                window.scrollTo({ top: 120, behavior: 'smooth' });
            });
        });
    </script>
    @endpush
</x-layouts.app>
