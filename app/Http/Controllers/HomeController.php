<?php

namespace App\Http\Controllers;

use App\Models\KatalogMobil;
use App\Models\KategoriMobil;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama MAZSEH.
     */
    public function index(Request $request): View
    {
        $categories = KategoriMobil::orderBy('nama_kategori')->get();

        $categoryFilter = $request->query('category');
        $carsQuery = KatalogMobil::with('kategori')
            ->where('status_ketersediaan', '!=', 'maintenance');

        if ($categoryFilter && $categoryFilter !== 'Semua') {
            $carsQuery->whereHas('kategori', function ($q) use ($categoryFilter) {
                $q->where('nama_kategori', $categoryFilter);
            });
        }

        $cars = $carsQuery->get();

        return view('public.home', compact('categories', 'cars'));
    }
}
