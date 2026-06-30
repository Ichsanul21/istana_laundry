<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *{font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased}
        .barcode-bg{background-image:repeating-linear-gradient(90deg,#000 0 2px,transparent 2px 4px,#000 4px 5px,transparent 5px 8px,#000 8px 9px,transparent 9px 11px,#000 11px 14px,transparent 14px 15px);opacity:.025}
        .grid-bg{background-image:linear-gradient(rgba(229,229,229,.25) 1px,transparent 1px),linear-gradient(90deg,rgba(229,229,229,.25) 1px,transparent 1px);background-size:72px 72px}
    </style>
</head>
<body class="bg-white text-black antialiased">
    <div class="fixed top-0 left-0 right-0 z-50 h-9 bg-black flex items-center justify-between px-4 lg:px-8">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#FF6B00] animate-pulse inline-block"></span>
            <span class="text-[11px] font-mono tracking-widest text-white/80 uppercase">Supported by Alenkosa</span>
        </div>
        <span class="text-[11px] font-mono tracking-wider text-white/40">ISTANA LAUNDRY · SAMARINDA</span>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-20 relative">
        <div class="barcode-bg absolute inset-0 pointer-events-none"></div>
        <div class="grid-bg absolute inset-0 pointer-events-none"></div>

        <a href="/" class="mb-8 relative z-10">
            <img src="/logo.png" alt="Istana Laundry" class="w-20 h-20 object-contain" style="filter:drop-shadow(0 8px 24px rgba(0,0,0,.1))">
        </a>

        <div class="w-full max-w-md relative z-10">
            <div class="bg-white/90 backdrop-blur-md border border-[#E5E5E5] p-8">
                {{ $slot }}
            </div>
        </div>

        <p class="mt-8 text-[11px] font-mono tracking-wider text-black/30 relative z-10">
            &copy; {{ date('Y') }} Istana Laundry Samarinda
        </p>
    </div>
</body>
</html>
