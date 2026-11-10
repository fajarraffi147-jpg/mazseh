<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Halaman Tentang Kami.
     */
    public function about(): View
    {
        return view('public.pages.about');
    }

    /**
     * Halaman Kontak & Form Hubungi Kami.
     */
    public function contact(): View
    {
        return view('public.pages.contact');
    }

    /**
     * Tangani pengiriman form kontak.
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email'],
            'topic' => ['required', 'string'],
            'message' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        return back()->with('success', 'Terima kasih, ' . $validated['name'] . '! Pesan Anda telah kami terima dan tim kami akan segera membalas ke email Anda.');
    }

    /**
     * Halaman Syarat & Ketentuan Sewa.
     */
    public function terms(): View
    {
        return view('public.pages.terms');
    }

    /**
     * Halaman Kebijakan Privasi.
     */
    public function privacy(): View
    {
        return view('public.pages.privacy');
    }
}
