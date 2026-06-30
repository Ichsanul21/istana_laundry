<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error {{ $code }} — Istana Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 'lo': '#FF6B00' },
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-black min-h-screen flex items-center justify-center px-5">
    <div class="max-w-md w-full text-center">
        <div class="text-8xl sm:text-9xl font-black tracking-tighter">
            <span class="text-black">{{ $code >= 500 ? '5' : '4' }}</span><span class="text-lo">0</span><span class="text-black">{{ $code >= 500 ? '0' : ($code === 404 ? '4' : '3') }}</span>
        </div>
        <div class="w-12 h-[2px] bg-lo mx-auto my-6"></div>
        <h1 class="text-xl sm:text-2xl font-black tracking-tight">{{ $message }}</h1>
        <p class="mt-3 text-sm text-black/50 leading-relaxed">
            @if($code === 404)
                Halaman yang Anda kunjungi mungkin telah dipindahkan atau tidak pernah ada.
            @elseif($code === 403)
                Silakan hubungi admin jika Anda membutuhkan akses.
            @elseif($code >= 500)
                Tim kami telah diberitahu dan sedang memperbaiki masalah ini.
            @else
                Silakan coba lagi dalam beberapa saat.
            @endif
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-8">
            <a href="/" class="inline-flex items-center gap-2 bg-lo text-white text-[12px] font-bold tracking-wider uppercase px-6 py-3 hover:bg-lo/90 transition-colors">
                Kembali ke Beranda
            </a>
            <a href="https://wa.me/628115599199" target="_blank" class="inline-flex items-center gap-2 bg-black text-white text-[12px] font-bold tracking-wider uppercase px-6 py-3 hover:bg-black/80 transition-colors">
                Hubungi Kami
            </a>
        </div>
        <div class="mt-10 flex items-center justify-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-lo"></span>
            <span class="text-[10px] font-mono tracking-wider text-black/30">ISTANA LAUNDRY · SAMARINDA</span>
        </div>
    </div>
</body>
</html>
