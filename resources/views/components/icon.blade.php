@props(['name', 'class' => ''])

@php
$paths = [
    'car' => 'M3 16V9l2-5h14l2 5v7M3 10h18M6 16h12M5 16v3H3v-3m16 0v3h2v-3M6 13h2m8 0h2',
    'search' => 'm21 21-5-5M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0',
    'pin' => 'M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 0 1 14 0ZM15 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0',
    'calendar' => 'M5 5h14v16H5zM8 2v6m8-6v6M5 10h14m-10 4h2m2 3h2',
    'arrow' => 'M4 12h15m-6-6 6 6-6 6',
    'chevron' => 'm9 5 7 7-7 7',
    'down' => 'm6 9 6 6 6-6',
    'check' => 'm5 12 4 4L19 6',
    'shield' => 'm12 2 9 4v6c0 5-9 10-9 10S3 17 3 12V6l9-4Zm-5 10 3 3 6-6',
    'clock' => 'M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0M12 6v6l4 2',
    'user' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0M4 22v-3a8 8 0 0 1 16 0v3',
    'users' => 'M14 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0M2 22v-3a8 8 0 0 1 16 0v3m0-19a4 4 0 0 1 0 8m2 3a7 7 0 0 1 2 5v3',
    'gear' => 'M6 3v14m0-9h12M18 3v14M12 8v13M3 3h6m6 0h6M3 17h6m6 0h6M9 21h6',
    'fuel' => 'M3 21V4h10v17M2 21h13M3 10h10m0 4h3v4a2 2 0 0 0 4 0V8l-4-4m2 2v4h2',
    'heart' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8',
    'menu' => 'M3 6h18M3 12h18M3 18h18',
    'close' => 'm6 6 12 12M6 18 18 6',
    'wallet' => 'M3 5h17v16H3V5Zm0 0V3h14v2m3 6h-6v5h6m-3-3h1',
    'receipt' => 'M5 2l3 2 4-2 4 2 3-2v20l-3-2-4 2-4-2-3 2V2Zm3 6h8m-8 4h8m-8 4h5',
    'dashboard' => 'M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z',
    'chart' => 'M3 3v18h18M7 16v-5m5 5V6m5 10V9',
    'wrench' => 'M21 5a6 6 0 0 1-8 8L5 21a2 2 0 0 1-3-3l8-8a6 6 0 0 1 8-8l-4 4 4 4 3-5Z',
    'logout' => 'M9 4H3v16h6m6-13 5 5-5 5M7 12h13',
    'bell' => 'M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9m-9 12h6',
    'plus' => 'M12 5v14M5 12h14',
    'edit' => 'm16 3 5 5-12 12-6 1 1-6L16 3Zm-3 3 5 5',
    'trash' => 'M3 6h18M9 6V3h6v3M5 6l1 15h12l1-15M10 10v7m4-7v7',
    'info' => 'M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0M12 11v6m0-10v1',
    'mail' => 'M3 5h18v14H3zM3 5l9 8 9-8',
    'phone' => 'm5 3 4 5-2 3a15 15 0 0 0 6 6l3-2 5 4c-5 7-23-11-16-16Z',
    'print' => 'M6 8V2h12v6M6 17H3V8h18v9h-3M6 14h12v8H6z',
    'download' => 'M12 3v12m-5-5 5 5 5-5M4 16v5h16v-5',
    'folder' => 'M3 5h7l2 3h9v13H3V5Z',
    'back' => 'M20 12H4m6-6-6 6 6 6',
    'key' => 'M14 5a5 5 0 1 1-7 7l-5 5v5h5v-3h3l4-4m2-10h.01',
    'spark' => 'M5 4v6m-3-3h6M16 3l2 6 5 2-5 2-2 6-2-6-5-2 5-2 2-6',
    'briefcase' => 'M3 7h18v14H3zM8 7V3h8v4M3 12l9 3 9-3M12 12v5',
    'list' => 'M9 5h12M9 12h12M9 19h12M3 5h1M3 12h1M3 19h1',
];
$d = $paths[$name] ?? $paths['info'];
@endphp
<svg {{ $attributes->merge(['class' => 'od-icon ' . $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="{{ $d }}"/>
</svg>
