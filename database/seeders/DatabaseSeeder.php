<?php

namespace Database\Seeders;

use App\Models\DocumentPelanggan;
use App\Models\KatalogMobil;
use App\Models\KategoriMobil;
use App\Models\Pembayaran;
use App\Models\SesiChatAi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna Demo
        $admin = User::firstOrCreate(
            ['email' => 'admin@mazseh.demo'],
            [
                'name' => 'Admin MAZSEH',
                'password' => Hash::make('mazseh123'),
                'role' => 'admin',
                'phone' => '080000000003',
                'city' => 'Semarang',
                'address' => 'Kantor Pusat MAZSEH, Semarang',
            ]
        );

        $kasir = User::firstOrCreate(
            ['email' => 'kasir@mazseh.demo'],
            [
                'name' => 'Kasir Contoh',
                'password' => Hash::make('mazseh123'),
                'role' => 'kasir',
                'phone' => '080000000002',
                'city' => 'Semarang',
                'address' => 'Pool MAZSEH Cabang Pemuda, Semarang',
            ]
        );

        $pelanggan = User::firstOrCreate(
            ['email' => 'pelanggan@mazseh.demo'],
            [
                'name' => 'Pelanggan Contoh',
                'password' => Hash::make('mazseh123'),
                'role' => 'pelanggan',
                'phone' => '081234567890',
                'city' => 'Semarang',
                'address' => 'Jl. Pandanaran No. 45, Semarang',
                'sim_number' => 'SIM-A-33740123456',
            ]
        );

        // Akun cadangan agar login budi / email umum tetap bekerja
        User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Pelanggan',
                'password' => Hash::make('mazseh123'),
                'role' => 'pelanggan',
                'phone' => '081298765432',
                'city' => 'Jakarta',
                'address' => 'Jl. Sudirman No. 12, Jakarta',
            ]
        );

        // 2. Kategori Kendaraan
        $kategoriMap = [];
        $kategoriList = ['MPV', 'SUV', 'Hatchback', 'Sedan'];
        foreach ($kategoriList as $nama) {
            $cat = KategoriMobil::firstOrCreate(['nama_kategori' => $nama]);
            $kategoriMap[$nama] = $cat->id_kategori;
        }

        // 3. 6 Unit Kendaraan Armada MAZSEH
        $carsData = [
            [
                'slug' => 'avanza',
                'id_kategori' => $kategoriMap['MPV'],
                'plat_nomor' => 'H 1001 DEM',
                'merk_model' => 'Toyota Avanza',
                'tahun' => 2024,
                'transmisi' => 'Otomatis',
                'jumlah_kursi' => 7,
                'bahan_bakar' => 'Bensin',
                'kota' => 'Semarang',
                'harga_sewa' => 350000.00,
                'status_ketersediaan' => 'tersedia',
                'foto_mobil' => '/assets/avanza.png',
                'label' => 'Perjalanan keluarga',
                'deskripsi' => 'Pilihan praktis untuk perjalanan bersama keluarga. Kabin tiga baris memberi ruang bagi penumpang dan kebutuhan perjalanan harian.',
                'fitur' => ['AC kabin', 'Audio & USB', 'Kursi tiga baris', 'Bagasi fleksibel'],
            ],
            [
                'slug' => 'zenix',
                'id_kategori' => $kategoriMap['MPV'],
                'plat_nomor' => 'H 1002 DEM',
                'merk_model' => 'Toyota Innova Zenix',
                'tahun' => 2024,
                'transmisi' => 'Otomatis',
                'jumlah_kursi' => 7,
                'bahan_bakar' => 'Hybrid',
                'kota' => 'Semarang',
                'harga_sewa' => 650000.00,
                'status_ketersediaan' => 'tersedia',
                'foto_mobil' => '/assets/zenix.png',
                'label' => 'Kenyamanan ekstra',
                'deskripsi' => 'Ruang kabin lega dengan karakter berkendara yang tenang untuk perjalanan bisnis maupun waktu bersama keluarga.',
                'fitur' => ['AC kabin', 'Audio & USB', 'Kursi tiga baris', 'Kabin lega'],
            ],
            [
                'slug' => 'fortuner',
                'id_kategori' => $kategoriMap['SUV'],
                'plat_nomor' => 'H 1003 DEM',
                'merk_model' => 'Toyota Fortuner',
                'tahun' => 2024,
                'transmisi' => 'Otomatis',
                'jumlah_kursi' => 7,
                'bahan_bakar' => 'Diesel',
                'kota' => 'Semarang',
                'harga_sewa' => 850000.00,
                'status_ketersediaan' => 'tersedia',
                'foto_mobil' => '/assets/fortuner.png',
                'label' => 'Siap menjelajah',
                'deskripsi' => 'SUV berkarakter kuat untuk menemani agenda perjalanan Anda. Posisi duduk tinggi dan ruang tujuh penumpang memberi fleksibilitas lebih.',
                'fitur' => ['AC kabin', 'Audio & USB', 'Kursi tiga baris', 'Posisi duduk tinggi'],
            ],
            [
                'slug' => 'agya',
                'id_kategori' => $kategoriMap['Hatchback'],
                'plat_nomor' => 'D 1004 DEM',
                'merk_model' => 'Toyota Agya',
                'tahun' => 2024,
                'transmisi' => 'Otomatis',
                'jumlah_kursi' => 5,
                'bahan_bakar' => 'Bensin',
                'kota' => 'Bandung',
                'harga_sewa' => 250000.00,
                'status_ketersediaan' => 'tersedia',
                'foto_mobil' => '/assets/agya.png',
                'label' => 'Mobilitas perkotaan',
                'deskripsi' => 'Mobil ringkas untuk aktivitas perkotaan, perjalanan singkat, dan kebutuhan mobilitas sehari-hari.',
                'fitur' => ['AC kabin', 'Audio & USB', 'Lima kursi', 'Bodi ringkas'],
            ],
            [
                'slug' => 'alphard',
                'id_kategori' => $kategoriMap['MPV'],
                'plat_nomor' => 'B 1005 DEM',
                'merk_model' => 'Toyota Alphard',
                'tahun' => 2024,
                'transmisi' => 'Otomatis',
                'jumlah_kursi' => 7,
                'bahan_bakar' => 'Hybrid',
                'kota' => 'Jakarta',
                'harga_sewa' => 2500000.00,
                'status_ketersediaan' => 'tersedia',
                'foto_mobil' => '/assets/alphard.png',
                'label' => 'Kelas premium',
                'deskripsi' => 'Kabin premium untuk agenda eksekutif dan momen istimewa. Ruang yang nyaman menjadi bagian dari perjalanan Anda.',
                'fitur' => ['AC kabin', 'Audio & USB', 'Kabin premium', 'Pintu geser'],
            ],
            [
                'slug' => 'camry',
                'id_kategori' => $kategoriMap['Sedan'],
                'plat_nomor' => 'L 1006 DEM',
                'merk_model' => 'Toyota Camry',
                'tahun' => 2024,
                'transmisi' => 'Otomatis',
                'jumlah_kursi' => 5,
                'bahan_bakar' => 'Hybrid',
                'kota' => 'Surabaya',
                'harga_sewa' => 1200000.00,
                'status_ketersediaan' => 'maintenance',
                'foto_mobil' => '/assets/camry.png',
                'label' => 'Perjalanan bisnis',
                'deskripsi' => 'Sedan untuk agenda bisnis dengan ruang kabin yang nyaman dan tampilan bersahaja.',
                'fitur' => ['AC kabin', 'Audio & USB', 'Lima kursi', 'Kabin sedan'],
            ],
        ];

        $carsMap = [];
        foreach ($carsData as $c) {
            $car = KatalogMobil::updateOrCreate(
                ['slug' => $c['slug']],
                $c
            );
            $carsMap[$c['slug']] = $car->id_mobil;
        }

        // 4. Dokumen Pelanggan Contoh
        DocumentPelanggan::updateOrCreate(
            ['user_id' => $pelanggan->id],
            [
                'file_ktp' => '/assets/sample-ktp.jpg',
                'file_sim' => '/assets/sample-sim.jpg',
                'status_verifikasi' => 'disetujui',
            ]
        );

        // 5. Contoh Transaksi & Pembayaran Awal
        if (isset($carsMap['avanza'])) {
            $t1 = Transaksi::updateOrCreate(
                ['kode_booking' => 'MZS-1028'],
                [
                    'user_id' => $pelanggan->id,
                    'id_mobil' => $carsMap['avanza'],
                    'tanggal_mulai' => now()->addDays(2)->format('Y-m-d'),
                    'tanggal_selesai' => now()->addDays(4)->format('Y-m-d'),
                    'waktu_ambil' => '09:00',
                    'metode_pengambilan' => 'Ambil di pool MAZSEH',
                    'opsi_pengemudi' => 'Lepas kunci',
                    'total_harga' => 700000.00,
                    'status_pesanan' => 'menunggu_pembayaran',
                    'titik_jemput' => 'Pool MAZSEH Semarang Barat, Jl. Pemuda No. 88',
                    'latitude' => '-6.974300',
                    'longitude' => '110.418400',
                    'catatan' => 'Perjalanan dinas keluarga.',
                    'waktu_pesan' => now()->subHours(3),
                ]
            );

            Pembayaran::updateOrCreate(
                ['id_transaksi' => $t1->id_transaksi],
                [
                    'jumlah_bayar' => 700000.00,
                    'status_pembayaran' => 'pending',
                    'metode_pembayaran' => 'Transfer bank',
                    'referensi_pembayaran' => 'TRX-SAMPLE-001',
                ]
            );
        }

        if (isset($carsMap['zenix'])) {
            $t2 = Transaksi::updateOrCreate(
                ['kode_booking' => 'MZS-1027'],
                [
                    'user_id' => $pelanggan->id,
                    'id_mobil' => $carsMap['zenix'],
                    'tanggal_mulai' => now()->subDays(2)->format('Y-m-d'),
                    'tanggal_selesai' => now()->format('Y-m-d'),
                    'waktu_ambil' => '10:00',
                    'metode_pengambilan' => 'Antar ke lokasi saya',
                    'opsi_pengemudi' => 'Lepas kunci',
                    'total_harga' => 1300000.00,
                    'status_pesanan' => 'dikonfirmasi',
                    'titik_jemput' => 'Bandara Jenderal Ahmad Yani, Semarang',
                    'latitude' => '-6.976500',
                    'longitude' => '110.380200',
                    'catatan' => 'Antar tepat waktu di lobby kedatangan.',
                    'waktu_pesan' => now()->subDays(3),
                ]
            );

            Pembayaran::updateOrCreate(
                ['id_transaksi' => $t2->id_transaksi],
                [
                    'kasir_id' => $kasir->id,
                    'jumlah_bayar' => 1300000.00,
                    'status_pembayaran' => 'lunas',
                    'metode_pembayaran' => 'QRIS',
                    'referensi_pembayaran' => 'QRIS-MZS-88992',
                    'waktu_bayar' => now()->subDays(3)->addMinutes(15),
                ]
            );
        }

        // 6. Sesi Chat AI Awal
        SesiChatAi::firstOrCreate(
            ['pesan_pelanggan' => 'Halo, apakah Toyota Fortuner tersedia untuk tanggal sewa besok?'],
            [
                'user_id' => $pelanggan->id,
                'balasan_ai' => 'Halo! Toyota Fortuner berkapasitas 7 penumpang dengan bahan bakar Diesel tersedia untuk pemesanan. Tarif mulai dari Rp850.000/hari.',
                'status_sesi' => 'diselesaikan_ai',
                'waktu_sesi' => now()->subDays(1),
            ]
        );
    }
}
