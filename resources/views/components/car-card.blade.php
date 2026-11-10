@props(['car', 'start' => null, 'end' => null])

@php
    $start = $start ?? request('start', now()->addDay()->format('Y-m-d'));
    $end = $end ?? request('end', now()->addDays(3)->format('Y-m-d'));
    $isAvailable = $car->isAvailableForDates($start, $end);
    $isMaintenance = $car->status_ketersediaan === 'maintenance';
@endphp

<article class="car-card">
    <a class="car-media" href="{{ route('catalog.show', ['slug' => $car->slug, 'start' => $start, 'end' => $end]) }}" aria-label="Lihat {{ $car->merk_model }}">
        <span class="car-tag">{{ $car->kategori->nama_kategori ?? 'Armada' }}</span>
        <img src="{{ asset($car->foto_mobil ?? 'assets/avanza.png') }}" width="600" height="400" alt="{{ $car->merk_model }}" loading="lazy">
    </a>
    <div class="car-body">
        <div class="car-heading">
            <h3>{{ $car->merk_model }}</h3>
            <span class="availability" @if(!$isAvailable || $isMaintenance) style="color:var(--amber)" @endif>
                @if($isAvailable && !$isMaintenance)
                    <x-icon name="check" />
                    <span>Tersedia</span>
                @elseif($isMaintenance)
                    <x-icon name="wrench" />
                    <span>Perawatan</span>
                @else
                    <x-icon name="clock" />
                    <span>Cek jadwal</span>
                @endif
            </span>
        </div>
        <p class="small">{{ $car->label ?? 'Pilihan armada MAZSEH' }}</p>
        
        <div class="car-specs">
            <span><x-icon name="gear" /> {{ $car->transmisi }}</span>
            <span><x-icon name="users" /> {{ $car->jumlah_kursi }} kursi</span>
            <span><x-icon name="fuel" /> {{ $car->bahan_bakar }}</span>
        </div>

        <div class="car-bottom">
            <div>
                <span class="price-label">Mulai dari</span>
                <span class="price">{{ $car->formatted_price }}<small> /hari</small></span>
            </div>
            <a href="{{ route('catalog.show', ['slug' => $car->slug, 'start' => $start, 'end' => $end]) }}" class="btn btn-outline">
                <span>Lihat Mobil</span>
                <x-icon name="arrow" />
            </a>
        </div>
    </div>
</article>
