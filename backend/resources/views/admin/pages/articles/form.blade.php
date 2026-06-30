@php $isEdit = isset($article); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Artikel' : 'Tambah Artikel' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Artikel' : 'Tambah Artikel' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.articles.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Artikel</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-ui.card title="Konten Artikel">
                    <x-form.input label="Judul" name="title" :value="old('title', $article->title ?? '')" required />
                    <div class="mt-4">
                        <x-form.input label="Slug" name="slug" :value="old('slug', $article->slug ?? '')" hint="Kosongkan untuk auto-generate dari judul" />
                    </div>
                    <div class="mt-4">
                        <label for="body" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konten <span class="text-error-500">*</span></label>
                        <textarea id="body" name="body" rows="15" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90" required>{{ old('body', $article->body ?? '') }}</textarea>
                    </div>
                    <div class="mt-4">
                        <x-form.textarea label="Excerpt" name="excerpt" :value="old('excerpt', $article->excerpt ?? '')" :rows="3" hint="Ringkasan singkat artikel (maks 500 karakter)" />
                    </div>
                </x-ui.card>

                <x-ui.card title="Gambar Utama">
                    <div class="flex items-start gap-4">
                        @if($isEdit && $article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="" class="w-32 h-32 rounded-lg object-cover">
                        @endif
                        <div class="flex-1">
                            <input type="file" name="featured_image" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-500 hover:file:bg-brand-100 dark:file:bg-brand-950/30 dark:file:text-brand-400 dark:hover:file:bg-brand-950/50 transition-colors cursor-pointer">
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Maks 2MB. Format: JPG, PNG, WebP</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-form.input label="Alt Text Gambar" name="alt_text" :value="old('alt_text', $article->alt_text ?? '')" hint="Deskripsi gambar untuk SEO" />
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card title="Publikasi">
                    <x-form.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled']" :value="old('status', $article->status ?? 'draft')" required />
                    <div class="mt-4">
                        <x-form.input label="Tanggal Publish" name="published_at" type="datetime-local" :value="old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '')" />
                    </div>
                </x-ui.card>

                <x-ui.card title="Kategori & Penulis">
                    <x-form.select label="Kategori" name="category_id" :options="$categories->pluck('name', 'id')->toArray()" :value="old('category_id', $article->category_id ?? '')" placeholder="Pilih kategori..." />
                    <div class="mt-4">
                        <x-form.input label="Penulis" name="author" :value="old('author', $article->author ?? auth()->user()->name)" />
                    </div>
                </x-ui.card>

                <x-ui.card title="SEO">
                    <div>
                        <x-form.input label="Meta Title" name="meta_title" :value="old('meta_title', $article->meta_title ?? '')" hint="Maks 70 karakter" />
                        <p class="text-right text-theme-xs text-gray-400 mt-1"><span id="metaTitleCount">0</span>/70</p>
                    </div>
                    <div class="mt-4">
                        <x-form.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $article->meta_description ?? '')" :rows="3" hint="Maks 160 karakter" />
                        <p class="text-right text-theme-xs text-gray-400 mt-1"><span id="metaDescCount">0</span>/160</p>
                    </div>
                    <div class="mt-4">
                        <x-form.input label="OG Title" name="og_title" :value="old('og_title', $article->og_title ?? '')" hint="Maks 70 karakter" />
                    </div>
                    <div class="mt-4">
                        <x-form.textarea label="OG Description" name="og_description" :value="old('og_description', $article->og_description ?? '')" :rows="2" hint="Maks 160 karakter" />
                    </div>
                </x-ui.card>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Publish Artikel' }}
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const metaTitle = document.querySelector('input[name="meta_title"]');
            const metaDesc = document.querySelector('textarea[name="meta_description"]');
            const titleCount = document.getElementById('metaTitleCount');
            const descCount = document.getElementById('metaDescCount');

            function updateCounts() {
                titleCount.textContent = metaTitle.value.length;
                descCount.textContent = metaDesc.value.length;
            }

            metaTitle.addEventListener('input', updateCounts);
            metaDesc.addEventListener('input', updateCounts);
            updateCounts();
        });
    </script>
    @endpush
</x-admin-layout>
