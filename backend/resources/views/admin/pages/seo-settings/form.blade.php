<x-admin-layout>
    <x-slot:title>Edit SEO - {{ ucfirst(str_replace('-', ' ', $seoSetting->page)) }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Edit SEO: {{ ucfirst(str_replace('-', ' ', $seoSetting->page)) }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.seo-settings.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">SEO Settings</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Edit</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.seo-settings.update', $seoSetting) }}" method="POST">
        @csrf @method('PUT')

        <div class="max-w-2xl">
            <x-ui.card title="Meta Tags">
                <x-form.input label="Meta Title" name="meta_title" :value="old('meta_title', $seoSetting->meta_title ?? '')" hint="Maks 70 karakter" />
                <p class="text-right text-theme-xs text-gray-400 mt-1"><span id="metaTitleCount">{{ strlen($seoSetting->meta_title ?? '') }}</span>/70</p>
                <div class="mt-4">
                    <x-form.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $seoSetting->meta_description ?? '')" :rows="3" hint="Maks 160 karakter" />
                    <p class="text-right text-theme-xs text-gray-400 mt-1"><span id="metaDescCount">{{ strlen($seoSetting->meta_description ?? '') }}</span>/160</p>
                </div>
            </x-ui.card>

            <x-ui.card title="Open Graph" class="mt-6">
                <x-form.input label="OG Title" name="og_title" :value="old('og_title', $seoSetting->og_title ?? '')" hint="Maks 70 karakter" />
                <div class="mt-4">
                    <x-form.textarea label="OG Description" name="og_description" :value="old('og_description', $seoSetting->og_description ?? '')" :rows="2" hint="Maks 160 karakter" />
                </div>
                <div class="mt-4">
                    <x-form.input label="OG Image URL" name="og_image" :value="old('og_image', $seoSetting->og_image ?? '')" hint="URL gambar untuk preview sosial media" />
                </div>
            </x-ui.card>

            <x-ui.card title="Schema" class="mt-6">
                <x-form.input label="Schema Type" name="schema_type" :value="old('schema_type', $seoSetting->schema_type ?? '')" hint="LocalBusiness, Article, FAQPage, ImageGallery, dll" />
            </x-ui.card>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.seo-settings.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
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
        });
    </script>
    @endpush
</x-admin-layout>
