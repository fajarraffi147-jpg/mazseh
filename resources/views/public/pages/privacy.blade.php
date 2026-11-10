<x-layouts.app title="Kebijakan Privasi | MAZSEH">
    <div class="container">
        <div class="page-top">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">Beranda</a>
                <x-icon name="chevron" />
                <span>Kebijakan privasi</span>
            </div>
            <div class="page-title">
                <h1>Kebijakan Privasi MAZSEH</h1>
                <p>Bagaimana kami melindungi dan mengelola data pribadi serta dokumen identitas Anda.</p>
            </div>
        </div>

        <article class="panel editorial" style="margin-bottom:48px;">
            <h2>1. Pengumpulan Informasi Pribadi</h2>
            <p>MAZSEH mengumpulkan data yang Anda berikan secara langsung saat melakukan pendaftaran akun, pemesanan armada, dan verifikasi dokumen (termasuk nama lengkap, alamat email, nomor telepon, dokumen KTP, dan SIM A).</p>

            <h2>2. Penggunaan Data Identitas & Dokumen</h2>
            <p>Dokumen identitas (KTP & SIM) hanya digunakan secara ketat untuk keperluan verifikasi legalitas pengemudi, keamanan aset kendaraan, dan validasi transaksi rental mobil. Kami tidak membagikan atau menjual data Anda kepada pihak ketiga manapun.</p>

            <h2>3. Keamanan Penyimpanan Data</h2>
            <p>Seluruh dokumen identitas disimpan pada direktori penyimpanan terenkripsi di server kami dengan hak akses terbatas yang hanya dapat diinspeksi oleh staf berwenang selama masa sewa aktif.</p>

            <h2>4. Hak Akses & Pembaruan Data</h2>
            <p>Anda berhak memperbarui informasi kontak, alamat penjemputan, atau memperbarui foto dokumen identitas Anda kapan saja melalui halaman profil akun MAZSEH Anda.</p>

            <div style="margin-top:32px;">
                <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
            </div>
        </article>
    </div>
</x-layouts.app>
