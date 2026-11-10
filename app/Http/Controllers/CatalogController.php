<?php

namespace App\Http\Controllers;

use App\Models\KatalogMobil;
use App\Models\KategoriMobil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Tampilkan katalog mobil dengan filter lengkap.
     */
    public function index(Request $request): View
    {
        $categories = KategoriMobil::orderBy('nama_kategori')->get();

        $start = $request->query('start', now()->addDay()->format('Y-m-d'));
        $end = $request->query('end', now()->addDays(3)->format('Y-m-d'));

        $query = KatalogMobil::with('kategori');

        // Filter nama mobil
        if ($search = $request->query('query')) {
            $query->where('merk_model', 'like', "%{$search}%");
        }

        // Filter kota
        if (($city = $request->query('city')) && $city !== 'Semua kota') {
            $query->where('kota', $city);
        }

        // Filter kategori
        if (($category = $request->query('category')) && $category !== 'Semua') {
            $query->whereHas('kategori', function ($q) use ($category) {
                $q->where('nama_kategori', $category);
            });
        }

        // Filter transmisi
        if (($trans = $request->query('transmission')) && $trans !== 'Semua') {
            $query->where('transmisi', $trans);
        }

        // Filter tarif maksimum
        if ($max = $request->query('max')) {
            $query->where('harga_sewa', '<=', (float) $max);
        }

        // Pengurutan
        $sort = $request->query('sort', 'Pilihan MAZSEH');
        if ($sort === 'Harga terendah') {
            $query->orderBy('harga_sewa', 'asc');
        } elseif ($sort === 'Harga tertinggi') {
            $query->orderBy('harga_sewa', 'desc');
        } else {
            $query->orderBy('id_mobil', 'asc');
        }

        $cars = $query->get();

        return view('public.catalog.index', compact('categories', 'cars', 'start', 'end'));
    }

    /**
     * Tampilkan detail unit mobil spesifik.
     */
    public function show(string $slug, Request $request): View
    {
        $car = KatalogMobil::with('kategori')
            ->where('slug', $slug)
            ->firstOrFail();

        $start = $request->query('start', now()->addDay()->format('Y-m-d'));
        $end = $request->query('end', now()->addDays(3)->format('Y-m-d'));

        return view('public.catalog.show', compact('car', 'start', 'end'));
    }
}
