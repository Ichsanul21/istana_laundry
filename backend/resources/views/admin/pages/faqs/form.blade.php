@php $isEdit = isset($faq); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit FAQ' : 'Tambah FAQ' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit FAQ' : 'Tambah FAQ' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.faqs.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">FAQ</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="max-w-2xl">
            <x-ui.card title="Informasi FAQ">
                <x-form.input label="Pertanyaan" name="question" :value="old('question', $faq->question ?? '')" required />
                <div class="mt-4">
                    <x-form.textarea label="Jawaban" name="answer" :value="old('answer', $faq->answer ?? '')" :rows="5" required />
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <x-form.input label="Kategori" name="category" :value="old('category', $faq->category ?? '')" placeholder="Layanan, Pembayaran, dll" />
                    <x-form.input label="Urutan" name="sort_order" type="number" min="0" :value="old('sort_order', $faq->sort_order ?? 0)" />
                </div>
                <div class="mt-4">
                    <x-form.checkbox label="Aktif" name="is_active" :checked="old('is_active', $faq->is_active ?? true)" />
                </div>
            </x-ui.card>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah FAQ' }}
                </button>
                <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
            </div>
        </div>
    </form>
</x-admin-layout>
