<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengecekan Karpet AI — Istana Laundry Samarinda</title>
    <meta name="description" content="Upload foto karpet Anda dan biarkan sistem AI kami menganalisa kondisinya: noda, jamur, keausan, hingga rekomendasi perawatan.">

    <meta property="og:title" content="Pengecekan Karpet AI — Istana Laundry Samarinda" />
    <meta property="og:description" content="Upload foto karpet, kami analisa kondisinya lewat AI dan beri rekomendasi perawatan terbaik." />
    <meta property="og:image" content="{{ asset('logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Istana Laundry Samarinda" />
    <meta property="og:locale" content="id_ID" />
    <meta property="twitter:card" content="summary_large_image" />

    <link rel="icon" href="{{ asset('logo.png') }}" sizes="32x32" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 'lo': '#FF6B00', 'lo-gray': '#E5E5E5' },
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        *{font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased}
        html{scroll-behavior:smooth}
        ::-webkit-scrollbar{width:5px}
        ::-webkit-scrollbar-track{background:#fff}
        ::-webkit-scrollbar-thumb{background:#E5E5E5}
        ::-webkit-scrollbar-thumb:hover{background:#000}
        .reveal{opacity:0;transform:translateY(36px);transition:all .55s cubic-bezier(.22,1,.36,1)}
        .reveal.on{opacity:1;transform:none}
        .d1{transition-delay:80ms}.d2{transition-delay:160ms}.d3{transition-delay:240ms}
        @keyframes snapUp{0%{transform:translateY(36px);opacity:0}55%{transform:translateY(-3px);opacity:1}80%{transform:translateY(1px)}100%{transform:translateY(0)}}
        .pulse-dot{animation:pulse-ring 2s ease-in-out infinite}
        @keyframes pulse-ring{0%,100%{box-shadow:0 0 0 0 rgba(255,107,0,.4)}50%{box-shadow:0 0 0 0 rgba(255,107,0,0)}}
        .cta-main{position:relative;overflow:hidden;transition:all .3s cubic-bezier(.22,1,.36,1)}
        .cta-main::after{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);transition:left .5s}
        .cta-main:hover::after{left:100%}
        .cta-main:hover{transform:scale(1.02);box-shadow:0 8px 30px -4px rgba(255,107,0,.4)}
        .cta-main:active{transform:scale(.97)}
        .nav-link{position:relative}
        .nav-link::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:2px;background:#FF6B00;transition:width .3s cubic-bezier(.22,1,.36,1)}
        .nav-link:hover::after{width:100%}
        .grid-bg{background-image:linear-gradient(rgba(229,229,229,.25) 1px,transparent 1px),linear-gradient(90deg,rgba(229,229,229,.25) 1px,transparent 1px);background-size:72px 72px}
        .drop-zone{border:2px dashed #E5E5E5;transition:all .25s cubic-bezier(.22,1,.36,1)}
        .drop-zone:hover,.drop-zone.dragover{border-color:#FF6B00;background:rgba(255,107,0,.04)}
    </style>
</head>
<body class="bg-white text-black overflow-x-hidden">

<!-- STATUS BAR -->
<div class="fixed top-0 left-0 right-0 z-50 h-9 bg-black flex items-center justify-between px-4 lg:px-8">
    <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-lo pulse-dot inline-block"></span>
        <span class="text-[11px] font-mono tracking-widest text-white/80 uppercase">Supported by Alenkosa</span>
    </div>
    <div class="hidden sm:flex items-center gap-4">
        <span class="text-[11px] font-mono tracking-wider text-white/40">ISTANA LAUNDRY · SAMARINDA</span>
    </div>
</div>

<!-- NAVIGATION -->
<nav class="fixed top-9 left-0 right-0 z-40 h-16 bg-white/95 backdrop-blur-md border-b border-lo-gray">
    <div class="max-w-4xl mx-auto h-full px-5 lg:px-8 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2.5">
            <img src="{{ asset('logo.png') }}" alt="Istana Laundry Logo" class="h-10 w-10 object-contain">
            <span class="font-bold text-sm tracking-tight sm:hidden">ISTANA <span class="text-lo">LAUNDRY</span></span>
        </a>
        <a href="/" class="text-[13px] font-semibold tracking-wide uppercase text-black/50 hover:text-black nav-link">← Beranda</a>
    </div>
</nav>

<!-- MAIN -->
<main class="pt-32 pb-24 px-5 lg:px-8 min-h-screen relative">
    <div class="grid-bg absolute inset-0 opacity-[.6] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-6 reveal on">
                <span class="w-8 h-[2px] bg-lo"></span>
                <span class="text-[11px] font-mono tracking-[.2em] uppercase text-black/40">AI Vision Diagnostics</span>
                <span class="w-8 h-[2px] bg-lo"></span>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tighter leading-[.95] reveal on d1">Pengecekan <span class="text-lo">Karpet</span> Anda</h1>
            <p class="mt-5 text-base sm:text-lg text-black/60 max-w-xl mx-auto leading-relaxed reveal on d2">Upload foto karpet Anda. Sistem AI kami akan menganalisa kondisi, mendeteksi noda, jamur, keausan, dan memberikan rekomendasi perawatan terbaik.</p>
        </div>

        {{-- Error / status --}}
        @if($errors->any())
            <div class="mb-8 border border-red-200 bg-red-50 p-5 reveal on">
                <div class="flex items-center gap-2 mb-2">
                    <span class="iconify text-red-500 text-xl" data-icon="lucide:x-circle"></span>
                    <span class="font-bold text-red-800">Periksa kembali isian Anda</span>
                </div>
                <ul class="text-sm text-red-700 list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('karpet.store') }}" enctype="multipart/form-data" id="karpetForm" class="grid lg:grid-cols-5 gap-6">
            @csrf

            {{-- Upload --}}
            <div class="lg:col-span-3 reveal on d2">
                <label class="text-xs font-bold tracking-wider uppercase text-black/40 mb-3 block">Foto Karpet <span class="text-lo">*</span></label>
                <label for="photo" id="dropZone" class="drop-zone flex flex-col items-center justify-center w-full aspect-[4/3] bg-white p-6 cursor-pointer text-center">
                    <span id="uploadIcon" class="iconify text-5xl text-lo mb-4" data-icon="lucide:image-up"></span>
                    <span id="uploadText" class="font-bold text-sm tracking-tight">Klik untuk upload foto karpet</span>
                    <span id="uploadSub" class="text-xs text-black/40 mt-1 font-mono">JPG, PNG, WebP · Maks 10 MB</span>
                </label>
                <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp" class="hidden">
                <div id="previewWrap" class="hidden mt-3 relative border border-lo-gray p-3 bg-white">
                    <img id="previewImg" src="" alt="Preview" class="w-full max-h-96 object-contain">
                    <button type="button" id="clearPhoto" class="absolute top-4 right-4 w-9 h-9 bg-black text-white flex items-center justify-center hover:bg-lo transition-colors">
                        <span class="iconify" data-icon="lucide:x"></span>
                    </button>
                </div>
            </div>

            {{-- Form fields --}}
            <div class="lg:col-span-2 space-y-4 reveal on d3">
                <div>
                    <label for="name" class="text-xs font-bold tracking-wider uppercase text-black/40 mb-1.5 block">Nama Lengkap <span class="text-lo">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda"
                        class="w-full border border-lo-gray px-4 py-3 text-sm focus:border-lo focus:outline-none transition-colors">
                </div>
                <div>
                    <label for="whatsapp" class="text-xs font-bold tracking-wider uppercase text-black/40 mb-1.5 block">No. WhatsApp <span class="text-lo">*</span></label>
                    <input type="tel" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" required placeholder="08xxxxxxxxxx"
                        class="w-full border border-lo-gray px-4 py-3 text-sm focus:border-lo focus:outline-none transition-colors">
                </div>
                <div>
                    <label for="notes" class="text-xs font-bold tracking-wider uppercase text-black/40 mb-1.5 block">Catatan (opsional)</label>
                    <textarea name="notes" id="notes" rows="4" placeholder="Jenis karpet, ukuran, keluhan, atau hal lain yang perlu kami ketahui..."
                        class="w-full border border-lo-gray px-4 py-3 text-sm focus:border-lo focus:outline-none transition-colors resize-none">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" id="submitBtn" class="cta-main w-full bg-lo text-white text-[13px] font-bold tracking-wider uppercase px-8 py-4 flex items-center justify-center gap-2">
                    <span id="submitIcon" class="iconify" data-icon="lucide:scan-line"></span>
                    <span id="submitText">Analisa Sekarang</span>
                </button>
                <p class="text-[11px] text-black/40 font-mono text-center">Analisa otomatis oleh AI · Hasil dalam hitungan detik</p>
            </div>
        </form>

        {{-- Cara kerja --}}
        <div class="mt-20 border-t border-lo-gray pt-16">
            <div class="flex items-center gap-3 mb-6 reveal"><span class="w-8 h-[2px] bg-lo"></span><span class="text-[11px] font-mono tracking-[.2em] uppercase text-black/40">Cara Kerja</span></div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tighter leading-[.95] max-w-lg reveal d1">Tiga Langkah Mudah</h2>
            <div class="grid sm:grid-cols-3 gap-4 mt-10">
                <div class="reveal d1 border border-lo-gray p-6"><div class="w-10 h-10 bg-black text-white flex items-center justify-center text-sm font-bold mb-4">01</div><h3 class="font-bold text-sm tracking-tight">Upload Foto</h3><p class="mt-2 text-sm text-black/50 leading-relaxed">Foto karpet dari berbagai sudut agar hasil lebih akurat.</p></div>
                <div class="reveal d2 border border-lo-gray p-6"><div class="w-10 h-10 bg-black text-white flex items-center justify-center text-sm font-bold mb-4">02</div><h3 class="font-bold text-sm tracking-tight">AI Analisa</h3><p class="mt-2 text-sm text-black/50 leading-relaxed">Sistem mendeteksi noda, jamur, keausan, dan kondisi keseluruhan.</p></div>
                <div class="reveal d3 border border-lo-gray p-6"><div class="w-10 h-10 bg-black text-white flex items-center justify-center text-sm font-bold mb-4">03</div><h3 class="font-bold text-sm tracking-tight">Rekomendasi</h3><p class="mt-2 text-sm text-black/50 leading-relaxed">Lihat hasil & rekomendasi, lalu order perawatan via WhatsApp.</p></div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-20 bg-black text-white p-10 text-center reveal">
            <h2 class="text-2xl sm:text-3xl font-black tracking-tighter">Saran Perawatan Langsung?</h2>
            <p class="mt-3 text-sm text-white/50 max-w-md mx-auto">Konsultasikan karpet Anda langsung dengan tim kami via WhatsApp.</p>
            <a href="https://wa.me/628115599199" class="cta-main inline-flex items-center gap-2.5 bg-lo text-white text-[13px] font-bold tracking-wider uppercase px-8 py-4 mt-6">
                <span class="iconify" data-icon="lucide:message-circle"></span>Hubungi via WhatsApp
            </a>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="border-t border-lo-gray py-8 px-5 lg:px-8">
    <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-[11px] font-mono tracking-wider text-black/30">&copy; {{ date('Y') }} Istana Laundry Samarinda</p>
        <a href="/" class="text-[11px] font-mono tracking-wider text-lo hover:text-black transition-colors">← Kembali ke Beranda</a>
    </div>
</footer>

<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('photo');
const previewWrap = document.getElementById('previewWrap');
const previewImg = document.getElementById('previewImg');
const clearPhoto = document.getElementById('clearPhoto');
const uploadIcon = document.getElementById('uploadIcon');
const uploadText = document.getElementById('uploadText');
const uploadSub = document.getElementById('uploadSub');

function showPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        previewWrap.classList.remove('hidden');
        dropZone.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

dropZone.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('change', () => showPreview(fileInput.files[0]));
clearPhoto.addEventListener('click', () => {
    fileInput.value = '';
    previewImg.src = '';
    previewWrap.classList.add('hidden');
    dropZone.classList.remove('hidden');
});

['dragenter','dragover'].forEach(ev => dropZone.addEventListener(ev, (e) => { e.preventDefault(); dropZone.classList.add('dragover'); }));
['dragleave','drop'].forEach(ev => dropZone.addEventListener(ev, (e) => { e.preventDefault(); dropZone.classList.remove('dragover'); }));
dropZone.addEventListener('drop', (e) => {
    const f = e.dataTransfer.files[0];
    if (f) {
        fileInput.files = e.dataTransfer.files;
        showPreview(f);
    }
});

const form = document.getElementById('karpetForm');
form.addEventListener('submit', () => {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    document.getElementById('submitIcon').setAttribute('data-icon', 'lucide:loader');
    document.getElementById('submitIcon').classList.add('animate-spin');
    document.getElementById('submitText').textContent = 'Sedang Menganalisa...';
});

const obs = new IntersectionObserver((entries) => {
    entries.forEach(x => { if (x.isIntersecting) x.target.classList.add('on'); });
}, { threshold: .1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>