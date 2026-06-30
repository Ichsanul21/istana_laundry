<x-admin-layout>
    <x-slot:title>{{ $article->title }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Detail Artikel</h2>
            <nav class="mt-1">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                    <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                    <li><a href="{{ route('admin.articles.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Artikel</a></li>
                    <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                    <li class="text-theme-sm text-gray-800 dark:text-white/90 truncate max-w-[200px]">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if($article->featured_image)
                <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03]">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->alt_text ?? $article->title }}" class="w-full h-auto max-h-[420px] object-cover">
                </div>
            @endif

            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 lg:p-8">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white/90 mb-4">{{ $article->title }}</h1>

                @if($article->excerpt)
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400 italic border-l-3 border-brand-500 pl-4 mb-6">{{ $article->excerpt }}</p>
                @endif

                <div class="prose prose-sm max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">
                    {{ $article->body }}
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <x-ui.card title="Info Artikel">
                <div class="space-y-3">
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Status</span>
                        @php
                            $statusColors = ['draft' => 'warning', 'published' => 'success', 'scheduled' => 'info'];
                            $statusLabels = ['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled'];
                        @endphp
                        <x-ui.badge :color="$statusColors[$article->status]" size="sm" class="mt-1">{{ $statusLabels[$article->status] }}</x-ui.badge>
                    </div>
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Dipublikasikan</span>
                        <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->published_at ? $article->published_at->format('d F Y, H:i') : '-' }}</span>
                    </div>
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Penulis</span>
                        <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->author }}</span>
                    </div>
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Kategori</span>
                        <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->category?->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Slug</span>
                        <code class="text-theme-xs text-brand-500 mt-1 block break-all">{{ $article->slug }}</code>
                    </div>
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Dibuat</span>
                        <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Diperbarui</span>
                        <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </x-ui.card>

            @if($article->meta_title || $article->meta_description)
                <x-ui.card title="SEO">
                    <div class="space-y-3">
                        @if($article->meta_title)
                            <div>
                                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Meta Title</span>
                                <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->meta_title }}</span>
                            </div>
                        @endif
                        @if($article->meta_description)
                            <div>
                                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Meta Description</span>
                                <p class="text-theme-sm text-gray-600 dark:text-gray-400 mt-1">{{ $article->meta_description }}</p>
                            </div>
                        @endif
                        @if($article->og_title)
                            <div>
                                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">OG Title</span>
                                <span class="text-theme-sm text-gray-800 dark:text-white/90 mt-1 block">{{ $article->og_title }}</span>
                            </div>
                        @endif
                        @if($article->og_description)
                            <div>
                                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">OG Description</span>
                                <p class="text-theme-sm text-gray-600 dark:text-gray-400 mt-1">{{ $article->og_description }}</p>
                            </div>
                        @endif
                        @if($article->og_image)
                            <div>
                                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">OG Image</span>
                                <code class="text-theme-xs text-brand-500 mt-1 block break-all">{{ $article->og_image }}</code>
                            </div>
                        @endif
                    </div>
                </x-ui.card>
            @endif
        </div>
    </div>
</x-admin-layout>
