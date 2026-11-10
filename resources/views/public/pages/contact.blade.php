<x-layouts.app title="Hubungi Kami | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Hubungi kami</span>
            </div>
            <div class="page-title">
                <h1>Mari bicarakan perjalanan Anda.</h1>
                <p>Sampaikan kebutuhan sewa, konsultasi rute, atau pertanyaan seputar pesanan Anda.</p>
            </div>
        </div>

        <div class="equal-col section-small">
            <div>
                <div class="contact-options">
                    <div class="contact-option">
                        <x-icon name="car" />
                        <div>
                            <h3>Bantuan Memilih Mobil</h3>
                            <p>Beritahu jumlah rombongan, tujuan perjalanan, dan durasi sewa Anda. Tim kami siap memberikan saran terbaik.</p>
                        </div>
                    </div>
                    <div class="contact-option">
                        <x-icon name="receipt" />
                        <div>
                            <h3>Pertanyaan Pesanan & Tagihan</h3>
                            <p>Sertakan kode booking pesanan Anda untuk memudahkan penelusuran status transaksi dan jadwal serah-terima.</p>
                        </div>
                    </div>
                    <div class="contact-option">
                        <x-icon name="pin" />
                        <div>
                            <h3>Kantor Pusat & Pool Utama</h3>
                            <p>Jl. Pemuda No. 88, Semarang, Jawa Tengah. Buka setiap hari pukul 07.00 - 22.00 WIB.</p>
                        </div>
                    </div>
                </div>

                <div class="spaced">
                    <div class="notice">
                        <x-icon name="phone" />
                        <span>Layanan Darurat & WhatsApp 24 Jam: <strong>+62 812-3456-7890</strong></span>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h2 style="font-size:22px; margin-bottom:16px;">Kirim Pesan</h2>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label for="contact-name">Nama lengkap *</label>
                        <input id="contact-name" name="name" type="text" value="{{ old('name', Auth::user()->name ?? '') }}" required maxlength="80">
                    </div>
                    <div class="field">
                        <label for="contact-email">Alamat email *</label>
                        <input id="contact-email" name="email" type="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label for="contact-topic">Topik *</label>
                        <select id="contact-topic" name="topic">
                            <option value="Pilihan mobil">Pilihan & Rekomendasi Mobil</option>
                            <option value="Pesanan saya">Pertanyaan Status Pesanan</option>
                            <option value="Kerja sama">Kerja Sama Perusahaan / Vendor</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="contact-message">Pesan *</label>
                        <textarea id="contact-message" name="message" rows="4" required placeholder="Ceritakan detail rencana atau kendala Anda..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary wfull" style="margin-top:12px;">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
