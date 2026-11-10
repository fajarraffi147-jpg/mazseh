<x-layouts.app title="Syarat & Ketentuan Sewa | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Ketentuan sewa</span>
            </div>
            <div class="page-title">
                <h1>Ketentuan Sewa Armada MAZSEH</h1>
                <p>Panduan dan syarat resmi penyewaan kendaraan untuk kenyamanan dan keamanan bersama.</p>
            </div>
        </div>

        <article class="panel editorial" style="margin-bottom:48px;">
            <h2>1. Persyaratan Identitas Penyewa</h2>
            <p>Penyewa wajib melampirkan foto dokumen asli berupa Kartu Tanda Penduduk (KTP) dan Surat Izin Mengemudi (SIM A) yang masih berlaku. Untuk layanan lepas kunci, MAZSEH berhak melakukan verifikasi keaslian dokumen sebelum unit diserahterimakan.</p>

            <h2>2. Perhitungan Durasi & Tarif Sewa</h2>
            <p>Durasi sewa dihitung per hari (24 jam) mulai dari jam pengambilan yang disepakati. Keterlambatan pengembalian unit melebihi toleransi waktu (grace period 1 jam) akan dikenakan biaya overtime sebesar 10% per jam dari tarif harian.</p>

            <h2>3. Layanan Sopir & Bahan Bakar</h2>
            <p>Tarif dasar sewa tidak mencakup bahan bakar (BBM), tarif tol, parkir, dan akomodasi pengemudi jika memilih sewa dengan sopir. Unit diserahterimakan dengan kondisi BBM terisi dan dikembalikan pada posisi indikator BBM yang sama.</p>

            <h2>4. Pembatalan & Pengembalian Dana</h2>
            <p>Pembatalan yang dilakukan lebih dari 24 jam sebelum jadwal pengambilan berhak atas pengembalian dana penuh atau penjadwalan ulang tanpa biaya penalti. Pembatalan mendadak kurang dari 12 jam dapat dikenakan biaya administrasi.</p>

            <div style="margin-top:32px;">
                <a href="{{ route('catalog.index') }}" class="btn btn-outline">Lihat Pilihan Mobil</a>
            </div>
        </article>
    </div>
</x-layouts.app>
