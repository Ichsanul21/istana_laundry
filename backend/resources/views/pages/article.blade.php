<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->meta_title ?? $article->title }} — Istana Laundry Samarinda</title>
    <meta name="description" content="{{ $article->meta_description ?? $article->excerpt ?? '' }}">

    <meta property="og:title" content="{{ $article->og_title ?? $article->meta_title ?? $article->title }}" />
    <meta property="og:description" content="{{ $article->og_description ?? $article->meta_description ?? $article->excerpt ?? '' }}" />
    <meta property="og:image" content="{{ $article->og_image ? (str_starts_with($article->og_image, 'http') ? $article->og_image : asset($article->og_image)) : ($article->featured_image ? asset('storage/'.$article->featured_image) : 'https://istanalaundry.alk-tech.my.id/logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="Istana Laundry Samarinda" />
    <meta property="og:locale" content="id_ID" />

    <link rel="icon" href="/logo.png" sizes="32x32" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://code.iconify.design/3/3.1.0/iconify.min.css">

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
        .barcode-bg{background-image:repeating-linear-gradient(90deg,#000 0 2px,transparent 2px 4px,#000 4px 5px,transparent 5px 8px,#000 8px 9px,transparent 9px 11px,#000 11px 14px,transparent 14px 15px);opacity:.025}
        .grid-bg{background-image:linear-gradient(rgba(229,229,229,.25) 1px,transparent 1px),linear-gradient(90deg,rgba(229,229,229,.25) 1px,transparent 1px);background-size:72px 72px}
        .nav-link{position:relative}
        .nav-link::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:2px;background:#FF6B00;transition:width .3s cubic-bezier(.22,1,.36,1)}
        .nav-link:hover::after{width:100%}
        .cta-main{position:relative;overflow:hidden;transition:all .3s cubic-bezier(.22,1,.36,1)}
        .cta-main::after{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);transition:left .5s}
        .cta-main:hover::after{left:100%}
        .cta-main:hover{transform:scale(1.02);box-shadow:0 8px 30px -4px rgba(255,107,0,.4)}
        .cta-main:active{transform:scale(.97)}
        .article-body h2{font-size:1.5rem;font-weight:800;margin-top:2rem;margin-bottom:0.75rem;letter-spacing:-0.02em}
        .article-body h3{font-size:1.25rem;font-weight:700;margin-top:1.5rem;margin-bottom:0.5rem}
        .article-body p{margin-bottom:1rem;line-height:1.8;color:rgba(0,0,0,.65)}
        .article-body ul,.article-body ol{margin-bottom:1rem;padding-left:1.5rem;line-height:1.8}
        .article-body li{margin-bottom:0.25rem;color:rgba(0,0,0,.65)}
        .article-body strong{font-weight:600;color:#000}
        .article-body a{color:#FF6B00;text-decoration:underline}
        .article-body a:hover{color:#000}
        .article-body blockquote{border-left:3px solid #FF6B00;padding-left:1.25rem;margin:1.5rem 0;color:rgba(0,0,0,.5);font-style:italic}
        .article-body img{border-radius:12px;margin:1.5rem 0;max-width:100%;height:auto}
    </style>
</head>
<body class="bg-white text-black">

    <!-- STATUS BAR -->
    <div class="fixed top-0 left-0 right-0 z-50 h-9 bg-black flex items-center justify-between px-4 lg:px-8">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#FF6B00] animate-pulse inline-block"></span>
            <span class="text-[11px] font-mono tracking-widest text-white/80 uppercase">Supported by Alenkosa</span>
        </div>
        <span class="text-[11px] font-mono tracking-wider text-white/40">ISTANA LAUNDRY · SAMARINDA</span>
    </div>

    <!-- NAVIGATION -->
    <nav class="fixed top-9 left-0 right-0 z-40 h-16 bg-white/95 backdrop-blur-md border-b border-gray-200">
        <div class="max-w-4xl mx-auto h-full px-5 lg:px-8 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <img src="/logo.png" alt="Istana Laundry Logo" class="h-9 w-9 object-contain">
                <span class="font-bold text-sm tracking-tight">ISTANA <span class="text-[#FF6B00]">LAUNDRY</span></span>
            </a>
            <a href="/#artikel" class="text-[13px] font-semibold tracking-wide uppercase text-black/50 hover:text-black nav-link">← Artikel</a>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="pt-28 pb-20 px-5 lg:px-8 min-h-screen relative">
        <div class="barcode-bg absolute inset-0 pointer-events-none"></div>
        <div class="grid-bg absolute inset-0 pointer-events-none"></div>

        <article class="max-w-4xl mx-auto relative z-10">
            @if($article->category)
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-6 h-[2px] bg-[#FF6B00]"></span>
                    <span class="text-[11px] font-mono tracking-[.2em] uppercase text-black/40">{{ $article->category->name }}</span>
                </div>
            @endif

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter leading-[1.05] mb-6">{{ $article->title }}</h1>

            <div class="flex flex-wrap items-center gap-4 text-[11px] font-mono tracking-wider text-black/40 mb-10 pb-6 border-b border-gray-200">
                @if($article->published_at)
                    <span>{{ $article->published_at->format('d F Y') }}</span>
                    <span class="w-1 h-1 rounded-full bg-black/20"></span>
                @endif
                <span>Oleh {{ $article->author }}</span>
                @if($article->category)
                    <span class="w-1 h-1 rounded-full bg-black/20"></span>
                    <a href="/#artikel" class="text-[#FF6B00] hover:text-black transition-colors">{{ $article->category->name }}</a>
                @endif
            </div>

            @if($article->featured_image)
                <div class="mb-10 rounded-2xl overflow-hidden">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->alt_text ?? $article->title }}" class="w-full h-auto max-h-[500px] object-cover">
                </div>
            @endif

            @if($article->excerpt)
                <p class="text-lg font-light text-black/50 italic border-l-3 border-[#FF6B00] pl-5 mb-8 leading-relaxed">{{ $article->excerpt }}</p>
            @endif

            <div class="article-body text-base leading-relaxed">
                {!! $article->body !!}
            </div>
        </article>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-gray-200 py-8 px-5 lg:px-8">
        <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-[11px] font-mono tracking-wider text-black/30">&copy; {{ date('Y') }} Istana Laundry Samarinda</p>
            <a href="/" class="text-[11px] font-mono tracking-wider text-[#FF6B00] hover:text-black transition-colors">← Kembali ke Beranda</a>
        </div>
    </footer>
</body>
</html>
