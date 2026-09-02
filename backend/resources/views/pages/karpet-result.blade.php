<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pengecekan Karpet — Istana Laundry Samarinda</title>
    <meta name="robots" content="noindex">

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
        .cta-main{position:relative;overflow:hidden;transition:all .3s cubic-bezier(.22,1,.36,1)}
        .cta-main::after{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);transition:left .5s}
        .cta-main:hover::after{left:100%}
        .cta-main:hover{transform:scale(1.02);box-shadow:0 8px 30px -4px rgba(255,107,0,.4)}
        .cta-main:active{transform:scale(.97)}
        .reveal{opacity:0;transform:translateY(36px);transition:all .55s cubic-bezier(.22,1,.36,1)}
        .reveal.on{opacity:1;transform:none}
        .d1{transition-delay:80ms}.d2{transition-delay:160ms}.d3{transition-delay:240ms}.d4{transition-delay:320ms}
        .pulse-dot{animation:pulse-ring 2s ease-in-out infinite}
        @keyframes pulse-ring{0%,100%{box-shadow:0 0 0 0 rgba(255,107,0,.4)}50%{box-shadow:0 0 0 0 rgba(255,107,0,0)}}
        @keyframes spin{to{transform:rotate(360deg)}}
        .animate-spin{animation:spin 1s linear infinite}
    </style>
</head>
<body class="bg-white text-black min-h-screen">

<!-- STATUS BAR -->
<div class="fixed top-0 left-0 right-0 z-50 h-9 bg-black flex items-center justify-between px-4 lg:px-8">
    <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-lo pulse-dot inline-block"></span>
        <span class="text-[11px] font-mono tracking-widest text-white/80 uppercase">Supported by Alenkosa</span>
    </div>
    <span class="text-[11px] font-mono tracking-wider text-white/40">ISTANA LAUNDRY · SAMARINDA</span>
</div>

<!-- NAVIGATION -->
<nav class="fixed top-9 left-0 right-0 z-40 h-16 bg-white/95 backdrop-blur-md border-b border-lo-gray">
    <div class="max-w-4xl mx-auto h-full px-5 lg:px-8 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2.5">
            <img src="{{ asset('logo.png') }}" alt="Istana Laundry Logo" class="h-10 w-10 object-contain">
            <span class="font-bold text-sm tracking-tight sm:hidden">ISTANA <span class="text-lo">LAUNDRY</span></span>
        </a>
        <div class="flex items-center gap-5">
            <a href="{{ route('karpet.index') }}" class="text-[13px] font-semibold tracking-wide uppercase text-black/50 hover:text-black nav-link hidden sm:block">Cek Lagi</a>
            <a href="/" class="text-[13px] font-semibold tracking-wide uppercase text-black/50 hover:text-black nav-link">← Beranda</a>
        </div>
    </div>
</nav>

<main class="pt-32 pb-24 px-5 lg:px-8 min-h-screen">
    <div class="max-w-4xl mx-auto">

        {{-- FAILED / PROCESSING --}}
        @if($inspection->status !== \App\Services\CarpetInspectionService::STATUS_COMPLETED)
            <div class="text-center max-w-xl mx-auto py-16 reveal on">
                @if($inspection->status === 'processing')
                    <div class="mx-auto w-16 h-16 border-4 border-lo-gray border-t-lo rounded-full animate-spin mb-6"></div>
                    <h1 class="text-3xl font-black tracking-tighter">Masih Menganalisa...</h1>
                    <p class="mt-4 text-black/50 text-sm leading-relaxed">Foto Anda sedang diproses oleh sistem AI kami. Silakan muat ulang halaman ini sebentar lagi.</p>
                @else
                    <div class="mx-auto w-16 h-16 bg-red-50 border border-red-200 rounded-full flex items-center justify-center mb-6">
                        <span class="iconify text-3xl text-red-500" data-icon="lucide:alert-triangle"></span>
                    </div>
                    <h1 class="text-3xl font-black tracking-tighter">Analisa Gagal</h1>
                    <p class="mt-4 text-black/50 text-sm leading-relaxed">{{ $inspection->error_message ?? 'Terjadi kendala saat menganalisa foto Anda.' }}</p>
                    <a href="{{ route('karpet.index') }}" class="cta-main inline-flex items-center gap-2 bg-lo text-white text-[13px] font-bold tracking-wider uppercase px-8 py-4 mt-8">
                        <span class="iconify" data-icon="lucide:refresh-cw"></span>Ulangi Pengecekan
                    </a>
                    <a href="https://wa.me/628115599199" class="inline-flex items-center gap-2 text-lo hover:text-black text-[13px] font-bold tracking-wider uppercase px-8 py-4 mt-4">
                        <span class="iconify" data-icon="lucide:message-circle"></span>Hubungi via WhatsApp
                    </a>
                @endif
            </div>
        @else
            {{-- SUCCESS HEADER --}}
            <div class="text-center mb-12 reveal on">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <span class="w-8 h-[2px] bg-lo"></span>
                    <span class="text-[11px] font-mono tracking-[.2em] uppercase text-black/40">Hasil Diagnosa</span>
                    <span class="w-8 h-[2px] bg-lo"></span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter leading-[.95]">Hasil Pengecekan <span class="text-lo">Karpet</span></h1>
                <p class="mt-3 text-sm text-black/40 font-mono">Untuk: {{ $inspection->name }} · {{ $inspection->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="grid lg:grid-cols-5 gap-8">
                {{-- Photo + score --}}
                <div class="lg:col-span-3 space-y-6">
                    <div class="reveal d1 border border-lo-gray overflow-hidden bg-[#FAFAFA]">
                        <img src="{{ $inspection->photo_url }}" alt="Foto karpet {{ $inspection->name }}" class="w-full object-cover">
                    </div>

                    @if($inspection->notes)
                        <div class="reveal d1 border border-lo-gray p-6 bg-[#FAFAFA]">
                            <div class="flex items-center gap-2 mb-3"><span class="iconify text-lo" data-icon="lucide:sticky-note"></span><span class="text-[10px] font-mono tracking-[.18em] uppercase text-black/40">Catatan Pelanggan</span></div>
                            <p class="text-sm text-black/60 leading-relaxed">{{ $inspection->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- Result details --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Score card --}}
                    <div class="reveal d1 border border-lo-gray p-6 bg-black text-white">
                        <div class="text-[10px] font-mono tracking-[.18em] uppercase text-white/40 mb-3">Skor Kebersihan</div>
                        <div class="flex items-end justify-between">
                            <span class="text-5xl font-black tracking-tighter text-lo">{{ $inspection->cleanliness_score }}<span class="text-2xl text-white/40">%</span></span>
                            <span class="text-sm font-bold uppercase tracking-wider {{ $inspection->overall_condition === 'Baik' ? 'text-emerald-400' : ($inspection->overall_condition === 'Buruk' ? 'text-red-400' : 'text-lo') }}">{{ $inspection->overall_condition }}</span>
                        </div>
                        <div class="mt-4 h-2 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-lo rounded-full" style="width:{{ $inspection->cleanliness_score }}%"></div>
                        </div>
                    </div>

                    {{-- Summary --}}
                    @if($inspection->summary)
                    <div class="reveal d2 border border-lo-gray p-6">
                        <div class="text-[10px] font-mono tracking-[.18em] uppercase text-black/40 mb-2">Ringkasan</div>
                        <p class="text-sm text-black/60 leading-relaxed">{{ $inspection->summary }}</p>
                    </div>
                    @endif

                    {{-- Findings --}}
                    <div class="reveal d3 border border-lo-gray p-6">
                        <div class="text-[10px] font-mono tracking-[.18em] uppercase text-black/40 mb-4">Temuan</div>
                        @forelse($inspection->findings ?? [] as $finding)
                            <div class="flex gap-3 py-3 border-b border-lo-gray last:border-0">
                                <span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 {{ $finding['severity'] === 'parah' ? 'bg-red-500' : ($finding['severity'] === 'sedang' ? 'bg-lo' : 'bg-yellow-400') }}"></span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-sm">{{ $finding['label'] }}</span>
                                        <span class="text-[9px] font-mono uppercase tracking-wider px-1.5 py-0.5 {{ $finding['severity'] === 'parah' ? 'bg-red-100 text-red-600' : ($finding['severity'] === 'sedang' ? 'bg-orange-100 text-lo' : 'bg-yellow-100 text-yellow-600') }}">{{ $finding['severity'] }}</span>
                                    </div>
                                    @if($finding['description'])
                                        <p class="text-xs text-black/50 mt-1 leading-relaxed">{{ $finding['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-black/40">Tidak ada temuan signifikan.</p>
                        @endforelse
                    </div>

                    {{-- Recommendation + CTA --}}
                    <div class="reveal d4 border-l-2 border-lo bg-[#FAFAFA] p-6">
                        <div class="text-[10px] font-mono tracking-[.18em] uppercase text-black/40 mb-2">Rekomendasi Perawatan</div>
                        @if($inspection->recommendation)
                            <p class="text-sm text-black/70 leading-relaxed">{{ $inspection->recommendation }}</p>
                        @endif
                        <a href="https://wa.me/628115599199?text={{ rawurlencode('Halo Istana Laundry, saya ingin order perawatan karpet. Hasil pengecekan: ' . $inspection->summary . ' (Skor ' . $inspection->cleanliness_score . '%, kondisi ' . $inspection->overall_condition . ')') }}" target="_blank" class="cta-main inline-flex items-center gap-2.5 bg-lo text-white text-[13px] font-bold tracking-wider uppercase px-6 py-3.5 mt-5">
                            <span class="iconify" data-icon="lucide:message-circle"></span>Order Perawatan via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-14 reveal d3">
                <a href="{{ route('karpet.index') }}" class="inline-flex items-center gap-2 text-[13px] font-bold tracking-wider uppercase text-black/60 hover:text-lo transition-colors">
                    <span class="iconify" data-icon="lucide:refresh-cw"></span>Cek Karpet Lainnya
                </a>
            </div>
        @endif
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
const obs = new IntersectionObserver((entries) => {
    entries.forEach(x => { if (x.isIntersecting) x.target.classList.add('on'); });
}, { threshold: .1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>