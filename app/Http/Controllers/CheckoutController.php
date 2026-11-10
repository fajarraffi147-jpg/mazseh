<?php

namespace App\Http\Controllers;

use App\Models\DocumentPelanggan;
use App\Models\KatalogMobil;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout 3 langkah untuk mobil yang dipilih.
     */
    public function create(string $slug, Request $request): View|RedirectResponse
    {
        $car = KatalogMobil::with('kategori')
            ->where('slug', $slug)
            ->firstOrFail();

        $start = $request->query('start', now()->addDay()->format('Y-m-d'));
        $end = $request->query('end', now()->addDays(3)->format('Y-m-d'));

        if (!$car->isAvailableForDates($start, $end)) {
            return redirect()->route('catalog.show', ['slug' => $car->slug, 'start' => $start, 'end' => $end])
                ->with('error', 'Maaf, unit ini tidak tersedia pada jadwal tanggal yang dipilih.');
        }

        $user = Auth::user();
        $document = $user->dokumenPelanggan;

        return view('customer.checkout.create', compact('car', 'start', 'end', 'document'));
    }

    /**
     * Simpan transaksi sewa baru, unggahan dokumen KTP & SIM, serta inisiasi pembayaran.
     */
    public function store(Request $request, string $slug): RedirectResponse
    {
        $car = KatalogMobil::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        $validated = $request->validate([
            'start' => ['required', 'date', 'after_or_equal:today'],
            'end' => ['required', 'date', 'after:start'],
            'waktu_ambil' => ['required', 'string'],
            'opsi_pengemudi' => ['required', 'in:Lepas kunci,Dengan sopir'],
            'metode_pengambilan' => ['required', 'string'],
            'titik_jemput' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'string', 'max:50'],
            'longitude' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:80'],
            'phone' => ['required', 'string', 'max:30'],
            'sim_number' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'string', 'max:500'],
            'file_ktp' => ['nullable', 'image', 'max:3072'],
            'file_sim' => ['nullable', 'image', 'max:3072'],
        ]);

        // Cek ketersediaan jadwal
        if (!$car->isAvailableForDates($validated['start'], $validated['end'])) {
            return back()->with('error', 'Maaf, unit telah dipesan oleh pelanggan lain pada jadwal ini.');
        }

        // Perbarui info user jika belum lengkap
        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'sim_number' => $validated['sim_number'],
            'address' => $validated['titik_jemput'],
        ]);

        // Upload Dokumen KTP & SIM
        $ktpPath = null;
        $simPath = null;
        if ($request->hasFile('file_ktp')) {
            $ktpPath = $request->file('file_ktp')->store('documents', 'public');
            $ktpPath = '/storage/' . $ktpPath;
        }
        if ($request->hasFile('file_sim')) {
            $simPath = $request->file('file_sim')->store('documents', 'public');
            $simPath = '/storage/' . $simPath;
        }

        $doc = DocumentPelanggan::firstOrNew(['user_id' => $user->id]);
        if ($ktpPath) {
            $doc->file_ktp = $ktpPath;
        }
        if ($simPath) {
            $doc->file_sim = $simPath;
        }
        if (!$doc->exists) {
            $doc->status_verifikasi = ($ktpPath && $simPath) ? 'menunggu_validasi' : 'belum_upload';
        } elseif ($ktpPath || $simPath) {
            $doc->status_verifikasi = 'menunggu_validasi';
        }
        $doc->save();

        // Kalkulasi Total Biaya
        $startDate = Carbon::parse($validated['start']);
        $endDate = Carbon::parse($validated['end']);
        $days = max(1, $startDate->diffInDays($endDate));
        $driverFee = ($validated['opsi_pengemudi'] === 'Dengan sopir') ? 200000 : 0;
        $totalHarga = ($car->harga_sewa + $driverFee) * $days;

        // Buat Kode Booking Unik
        $kodeBooking = 'MZS-' . strtoupper(Str::random(6));

        // Buat Record Transaksi
        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'id_mobil' => $car->id_mobil,
            'kode_booking' => $kodeBooking,
            'tanggal_mulai' => $validated['start'],
            'tanggal_selesai' => $validated['end'],
            'waktu_ambil' => $validated['waktu_ambil'],
            'opsi_pengemudi' => $validated['opsi_pengemudi'],
            'metode_pengambilan' => $validated['metode_pengambilan'],
            'titik_jemput' => $validated['titik_jemput'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'total_harga' => $totalHarga,
            'status_pesanan' => 'menunggu_pembayaran',
            'catatan' => $validated['catatan'] ?? null,
            'waktu_pesan' => now(),
        ]);

        // Buat Record Pembayaran Awal
        Pembayaran::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'jumlah_bayar' => $totalHarga,
            'status_pembayaran' => 'pending',
            'metode_pembayaran' => 'Transfer bank',
            'referensi_pembayaran' => null,
        ]);

        return redirect()->route('orders.payment', $transaksi->id_transaksi)
            ->with('success', 'Pesanan ' . $kodeBooking . ' berhasil dibuat! Silakan selesaikan pembayaran.');
    }
}
