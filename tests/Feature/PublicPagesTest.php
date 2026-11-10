<?php

namespace Tests\Feature;

use App\Models\KatalogMobil;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    /**
     * Pastikan halaman beranda merender HTTP 200 dan memuat nama brand MAZSEH.
     */
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('MAZSEH');
        $response->assertSee('Tujuan Anda.');
        $response->assertSee('Toyota Fortuner');
    }

    /**
     * Pastikan katalog mobil dapat diakses beserta filter kategori.
     */
    public function test_catalog_page_and_filter_render(): void
    {
        $response = $this->get('/cars');
        $response->assertStatus(200);
        $response->assertSee('Pilih mobil, mulai perjalanan.');

        $filterResponse = $this->get('/cars?category=SUV');
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('Toyota Fortuner');
    }

    /**
     * Pastikan detail unit mobil dapat diakses.
     */
    public function test_car_detail_page_renders(): void
    {
        $car = KatalogMobil::where('slug', 'avanza')->first();
        $this->assertNotNull($car);

        $response = $this->get('/cars/' . $car->slug);
        $response->assertStatus(200);
        $response->assertSee($car->merk_model);
        $response->assertSee('Transmisi');
    }

    /**
     * Pastikan halaman informasi statis (Tentang Kami, Kontak, Syarat, Privasi) bekerja.
     */
    public function test_static_pages_render(): void
    {
        $this->get('/about')->assertStatus(200)->assertSee('Tentang MAZSEH');
        $this->get('/contact')->assertStatus(200)->assertSee('Mari bicarakan perjalanan Anda.');
        $this->get('/terms')->assertStatus(200)->assertSee('Ketentuan Sewa Armada MAZSEH');
        $this->get('/privacy')->assertStatus(200)->assertSee('Kebijakan Privasi MAZSEH');
    }

    /**
     * Pastikan form kontak dapat mengirim pesan.
     */
    public function test_contact_form_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com',
            'topic' => 'Pilihan mobil',
            'message' => 'Halo, saya ingin menanyakan mobil untuk keluarga 7 orang.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Pastikan API AI Chatbot merespon pertanyaan dan menyimpan sesi chat.
     */
    public function test_ai_chatbot_endpoint(): void
    {
        $response = $this->postJson('/ai-chat', [
            'message' => 'Apakah Toyota Fortuner tersedia?',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['reply', 'status']);
        $this->assertDatabaseHas('sesi_chat_ai', [
            'pesan_pelanggan' => 'Apakah Toyota Fortuner tersedia?',
        ]);
    }
}
