<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan milik pelanggan.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        $query = Transaksi::with(['mobil', 'pembayaran'])
            ->where('user_id', $user->id)
            ->orderBy('id_transaksi', 'desc');

        if ($status = $request->query('status')) {
            if ($status !== 'Semua') {
                $query->where('status_pesanan', $status);
            }
        }

        $orders = $query->get();

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan lengkap beserta riwayat timeline.
     */
    public function show(int $id): View|RedirectResponse
    {
        $user = Auth::user();
        $order = Transaksi::with(['mobil', 'pembayaran', 'user'])
            ->where('user_id', $user->id)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Tampilkan halaman instruksi dan konfirmasi pembayaran.
     */
    public function payment(int $id): View|RedirectResponse
    {
        $user = Auth::user();
        $transaksi = Transaksi::with(['mobil', 'pembayaran', 'user'])
            ->where('user_id', $user->id)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        return view('customer.orders.payment', compact('transaksi'));
    }

    /**
     * Simpan konfirmasi pembayaran dari pelanggan.
     */
    public function submitPayment(Request $request, int $id): RedirectResponse
    {
        $user = Auth::user();
        $transaksi = Transaksi::with(['mobil', 'pembayaran'])
            ->where('user_id', $user->id)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'metode_pembayaran' => ['required', 'string'],
            'referensi_pembayaran' => ['nullable', 'string', 'max:100'],
            'bukti_bayar' => ['nullable', 'image', 'max:3072'],
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiPath = $request->file('bukti_bayar')->store('payments', 'public');
            $buktiPath = '/storage/' . $buktiPath;
        }

        $pembayaran = $transaksi->pembayaran ?? new Pembayaran(['id_transaksi' => $transaksi->id_transaksi]);
        $pembayaran->metode_pembayaran = $validated['metode_pembayaran'];
        $pembayaran->referensi_pembayaran = $validated['referensi_pembayaran'] ?? 'PAY-' . strtoupper(bin2hex(random_bytes(4)));
        if ($buktiPath) {
            $pembayaran->bukti_bayar = $buktiPath;
        }
        $pembayaran->jumlah_bayar = $transaksi->total_harga;
        $pembayaran->status_pembayaran = 'lunas';
        $pembayaran->waktu_bayar = now();
        $pembayaran->save();

        $transaksi->update([
            'status_pesanan' => 'dikonfirmasi',
        ]);

        return redirect()->route('orders.confirmed', $transaksi->id_transaksi)
            ->with('success', 'Konfirmasi pembayaran berhasil dicatat! Status pesanan kini telah aktif.');
    }

    /**
     * Tampilkan halaman sukses konfirmasi pesanan.
     */
    public function confirmed(int $id): View|RedirectResponse
    {
        $user = Auth::user();
        $transaksi = Transaksi::with(['mobil', 'pembayaran', 'user'])
            ->where('user_id', $user->id)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        return view('customer.orders.confirmed', compact('transaksi'));
    }

    /**
     * Tampilkan bukti sewa resmi (invoice) siap cetak.
     */
    public function receipt(int $id): View|RedirectResponse
    {
        $user = Auth::user();
        $order = Transaksi::with(['mobil', 'pembayaran', 'user'])
            ->where('user_id', $user->id)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        return view('customer.orders.receipt', compact('order'));
    }

    /**
     * Batalkan pesanan sewa jika belum dibayar/diserahterimakan.
     */
    public function cancel(Request $request, int $id): RedirectResponse
    {
        $user = Auth::user();
        $order = Transaksi::where('user_id', $user->id)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        if ($order->status_pesanan === 'dibatalkan') {
            return back()->with('error', 'Pesanan ini sudah dibatalkan sebelumnya.');
        }

        $validated = $request->validate([
            'alasan_batal' => ['required', 'string', 'max:500'],
        ]);

        $order->update([
            'status_pesanan' => 'dibatalkan',
            'alasan_batal' => $validated['alasan_batal'],
        ]);

        return redirect()->route('orders.show', $order->id_transaksi)
            ->with('success', 'Pesanan ' . $order->kode_booking . ' telah berhasil dibatalkan.');
    }
}
