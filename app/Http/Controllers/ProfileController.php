<?php

namespace App\Http\Controllers;

use App\Models\DocumentPelanggan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil pelanggan beserta status dokumen identitas.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $document = $user->dokumenPelanggan;

        return view('customer.profile.edit', compact('user', 'document'));
    }

    /**
     * Simpan pembaruan data profil dan berkas dokumen KTP & SIM.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'sim_number' => ['nullable', 'string', 'max:50'],
            'file_ktp' => ['nullable', 'image', 'max:3072'],
            'file_sim' => ['nullable', 'image', 'max:3072'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'sim_number' => $validated['sim_number'] ?? null,
        ]);

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

        if ($ktpPath || $simPath) {
            $doc = DocumentPelanggan::firstOrNew(['user_id' => $user->id]);
            if ($ktpPath) {
                $doc->file_ktp = $ktpPath;
            }
            if ($simPath) {
                $doc->file_sim = $simPath;
            }
            $doc->status_verifikasi = 'menunggu_validasi';
            $doc->save();
        }

        return back()->with('success', 'Data profil Anda berhasil diperbarui.');
    }
}
