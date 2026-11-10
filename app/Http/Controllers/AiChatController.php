<?php

namespace App\Http\Controllers;

use App\Models\KatalogMobil;
use App\Models\SesiChatAi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiChatController extends Controller
{
    /**
     * Tangani pengiriman pesan ke Asisten AI MAZSEH dan simpan riwayat ke database.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = trim($validated['message']);
        $lower = strtolower($message);

        $statusSesi = 'diselesaikan_ai';
        $whatsappUrl = null;
        $reply = '';

        // Deteksi kebutuhan eskalasi ke WhatsApp Staf Admin
        if (str_contains($lower, 'wa') || str_contains($lower, 'whatsapp') || str_contains($lower, 'admin') || str_contains($lower, 'cs') || str_contains($lower, 'manusia') || str_contains($lower, 'telepon')) {
            $statusSesi = 'dialihkan_ke_wa';
            $encodedText = urlencode("Halo Admin MAZSEH, saya ingin konsultasi langsung mengenai pertanyaan ini: \"{$message}\"");
            $whatsappUrl = "https://wa.me/6281234567890?text={$encodedText}";
            $reply = "Tentu! Anda dapat langsung terhubung dengan tim customer service kami melalui WhatsApp untuk respon cepat.";
        }
        // Deteksi pertanyaan spesifik tentang unit mobil
        elseif (str_contains($lower, 'fortuner')) {
            $car = KatalogMobil::where('slug', 'fortuner')->first();
            $price = $car ? $car->formatted_price : 'Rp850.000';
            $reply = "Toyota Fortuner adalah SUV 7-seater tangguh dengan mesin Diesel bertenaga. Tarif sewanya mulai dari {$price}/hari. Sangat cocok untuk perjalanan medan berat dan luar kota.";
        } elseif (str_contains($lower, 'zenix') || str_contains($lower, 'innova')) {
            $car = KatalogMobil::where('slug', 'zenix')->first();
            $price = $car ? $car->formatted_price : 'Rp650.000';
            $reply = "Toyota Innova Zenix hadir dengan teknologi mesin Hybrid yang senyap, kabin luas 7 penumpang, dan suspensi nyaman. Tarif sewa mulai dari {$price}/hari.";
        } elseif (str_contains($lower, 'avanza')) {
            $car = KatalogMobil::where('slug', 'avanza')->first();
            $price = $car ? $car->formatted_price : 'Rp350.000';
            $reply = "Toyota All New Avanza adalah pilihan MPV keluarga terfavorit kami dengan kapasitas 7 penumpang. Praktis dan hemat, tarif sewa mulai dari {$price}/hari.";
        } elseif (str_contains($lower, 'agya')) {
            $car = KatalogMobil::where('slug', 'agya')->first();
            $price = $car ? $car->formatted_price : 'Rp250.000';
            $reply = "Toyota Agya GR Sport merupakan city car lincah berkapasitas 5 penumpang, ideal untuk mobilitas padat di dalam kota dengan tarif paling hemat mulai dari {$price}/hari.";
        } elseif (str_contains($lower, 'alphard')) {
            $car = KatalogMobil::where('slug', 'alphard')->first();
            $price = $car ? $car->formatted_price : 'Rp2.500.000';
            $reply = "Toyota Alphard Executive Lounge adalah MPV kelas premium kami berkapasitas 7 kursi dengan pintu geser otomatis dan kabin mewah VIP. Tarif sewa mulai dari {$price}/hari.";
        } elseif (str_contains($lower, 'camry')) {
            $car = KatalogMobil::where('slug', 'camry')->first();
            $price = $car ? $car->formatted_price : 'Rp1.200.000';
            $reply = "Toyota Camry Hybrid adalah sedan eksekutif mewah berkapasitas 5 penumpang dengan tarif sewa {$price}/hari, memberikan kenyamanan berkelas untuk perjalanan bisnis dan dinas.";
        }
        // Deteksi pertanyaan rekomendasi
        elseif (str_contains($lower, 'keluarga') || str_contains($lower, 'rombongan')) {
            $reply = "Untuk perjalanan keluarga atau rombongan (7 orang), kami sangat merekomendasikan Toyota Innova Zenix untuk kenyamanan ekstra atau Toyota Avanza untuk opsi yang lebih ekonomis.";
        } elseif (str_contains($lower, 'hemat') || str_contains($lower, 'murah')) {
            $reply = "Pilihan paling hemat saat ini adalah Toyota Agya (Rp250.000/hari) untuk 5 penumpang, atau Toyota Avanza (Rp350.000/hari) jika membutuhkan kapasitas 7 penumpang.";
        } elseif (str_contains($lower, 'syarat') || str_contains($lower, 'dokumen') || str_contains($lower, 'ktp') || str_contains($lower, 'sim')) {
            $reply = "Syarat utama sewa di MAZSEH cukup menyiapkan foto KTP asli dan SIM A aktif. Anda dapat langsung mengunggahnya pada formulir pemesanan atau di menu profil akun Anda.";
        } elseif (str_contains($lower, 'sopir') || str_contains($lower, 'driver')) {
            $reply = "Kami menyediakan opsi 'Lepas Kunci' atau 'Dengan Sopir'. Layanan sopir profesional kami hanya bertarif tambahan Rp200.000 per hari di luar biaya BBM, tol, dan parkir.";
        } else {
            $reply = "Halo! MAZSEH menyediakan berbagai pilihan armada seperti Avanza, Zenix, Fortuner, Agya, dan Alphard dengan opsi sewa lepas kunci maupun dengan sopir. Ada tipe mobil atau jadwal sewa tertentu yang sedang Anda cari?";
        }

        // Simpan ke database sesi_chat_ai
        $userId = Auth::id() ?? 1; // Jika tamu belum login, kaitkan ke id akun default
        SesiChatAi::create([
            'user_id' => $userId,
            'pesan_pelanggan' => $message,
            'balasan_ai' => $reply,
            'status_sesi' => $statusSesi,
            'waktu_sesi' => now(),
        ]);

        return response()->json([
            'reply' => $reply,
            'status' => $statusSesi,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }
}
