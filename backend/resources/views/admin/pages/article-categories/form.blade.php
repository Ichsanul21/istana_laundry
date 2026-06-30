@php $isEdit = isset($category); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.article-categories.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Kategori</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.article-categories.update', $category) : route('admin.article-categories.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="max-w-2xl">
            <x-ui.card title="Informasi Kategori">
                <x-form.input label="Nama Kategori" name="name" :value="old('name', $category->name ?? '')" required />
                <div class="mt-4">
                    <x-form.input label="Slug" name="slug" :value="old('slug', $category->slug ?? '')" hint="Kosongkan untuk auto-generate dari nama" />
                </div>
            </x-ui.card>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                </button>
                <a href="{{ route('admin.article-categories.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
            </div>
        </div>
    </form>
</x-admin-layout>
