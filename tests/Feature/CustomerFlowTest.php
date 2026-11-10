<?php

namespace Tests\Feature;

use App\Models\KatalogMobil;
use App\Models\Transaksi;
use App\Models\User;
use Tests\TestCase;

class CustomerFlowTest extends TestCase
{
    /**
     * Pastikan halaman login dan registrasi dapat diakses tamu.
     */
    public function test_auth_pages_accessible(): void
    {
        $this->get('/login')->assertStatus(200)->assertSee('Selamat datang kembali');
        $this->get('/register')->assertStatus(200)->assertSee('Buat akun MAZSEH');
        $this->get('/forgot-password')->assertStatus(200)->assertSee('Lupa kata sandi?');
    }

    /**
     * Pastikan proses checkout, upload dokumen, titik jemput GPS, dan pembayaran berjalan lancar.
     */
    public function test_customer_complete_rental_flow(): void
    {
        $user = User::where('email', 'pelanggan@mazseh.demo')->first();
        $this->assertNotNull($user);

        $car = KatalogMobil::where('slug', 'avanza')->first();
        $this->assertNotNull($car);

        // 1. Akses Checkout (sebagai pelanggan yang login dengan rentang tanggal tersedia)
        $start = now()->addDays(10)->format('Y-m-d');
        $end = now()->addDays(12)->format('Y-m-d');
        $checkoutPage = $this->actingAs($user)->get('/checkout/' . $car->slug . "?start={$start}&end={$end}");
        $checkoutPage->assertStatus(200);
        $checkoutPage->assertSee('Lengkapi rencana perjalanan');
        $checkoutPage->assertSee('Titik Koordinat GPS');

        // 2. Submit Pemesanan Checkout
        $response = $this->actingAs($user)->post('/checkout/' . $car->slug, [
            'start' => now()->addDays(10)->format('Y-m-d'),
            'end' => now()->addDays(12)->format('Y-m-d'),
            'waktu_ambil' => '09:00',
            'opsi_pengemudi' => 'Lepas kunci',
            'metode_pengambilan' => 'Ambil di pool MAZSEH',
            'titik_jemput' => 'Pool MAZSEH Semarang Barat, Jl. Pemuda No. 88',
            'latitude' => '-6.974300',
            'longitude' => '110.418400',
            'name' => $user->name,
            'phone' => '081234567890',
            'sim_number' => 'SIM-A-33740123456',
            'catatan' => 'Mohon siapkan unit bersih.',
        ]);

        $response->assertRedirect();
        
        $transaksi = Transaksi::where('user_id', $user->id)
            ->where('tanggal_mulai', now()->addDays(10)->format('Y-m-d'))
            ->first();

        $this->assertNotNull($transaksi);
        $this->assertEquals('-6.974300', $transaksi->latitude);
        $this->assertEquals('110.418400', $transaksi->longitude);
        $this->assertEquals('menunggu_pembayaran', $transaksi->status_pesanan);

        // 3. Akses Halaman Pembayaran
        $paymentPage = $this->actingAs($user)->get('/orders/' . $transaksi->id_transaksi . '/payment');
        $paymentPage->assertStatus(200);
        $paymentPage->assertSee('Pilih metode pembayaran');

        // 4. Submit Pembayaran
        $submitPay = $this->actingAs($user)->post('/orders/' . $transaksi->id_transaksi . '/payment', [
            'metode_pembayaran' => 'QRIS',
            'referensi_pembayaran' => 'QRIS-TEST-9901',
        ]);

        $submitPay->assertRedirect(route('orders.confirmed', $transaksi->id_transaksi));
        $transaksi->refresh();
        $this->assertEquals('dikonfirmasi', $transaksi->status_pesanan);
        $this->assertEquals('lunas', $transaksi->pembayaran->status_pembayaran);

        // 5. Akses Halaman Konfirmasi & Cetak Kuitansi
        $this->actingAs($user)->get('/orders/' . $transaksi->id_transaksi . '/confirmed')
            ->assertStatus(200)
            ->assertSee('Pesanan Anda Berhasil Diproses!');

        $this->actingAs($user)->get('/orders/' . $transaksi->id_transaksi . '/receipt')
            ->assertStatus(200)
            ->assertSee('Kuitansi Resmi Pembayaran');

        // 6. Akses Halaman Profil & Update
        $this->actingAs($user)->get('/profile')
            ->assertStatus(200)
            ->assertSee('Profil saya');

        $profileUpdate = $this->actingAs($user)->put('/profile', [
            'name' => 'Pelanggan Updated',
            'email' => $user->email,
            'phone' => '081234567899',
            'city' => 'Semarang',
            'address' => 'Jl. Pandanaran No. 100, Semarang',
            'sim_number' => 'SIM-A-33740123456',
        ]);
        $profileUpdate->assertRedirect();
        $user->refresh();
        $this->assertEquals('Pelanggan Updated', $user->name);
    }
}
