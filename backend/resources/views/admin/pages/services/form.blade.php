@php $isEdit = isset($service); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Layanan' : 'Tambah Layanan' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Layanan' : 'Tambah Layanan' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.services.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Layanan</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="max-w-2xl">
            <x-ui.card title="Informasi Layanan">
                <x-form.input label="Nama Layanan" name="name" :value="old('name', $service->name ?? '')" required />
                <div class="mt-4">
                    <x-form.input label="Slug" name="slug" :value="old('slug', $service->slug ?? '')" hint="Kosongkan untuk auto-generate" />
                </div>
                <div class="mt-4">
                    <x-form.textarea label="Deskripsi" name="description" :value="old('description', $service->description ?? '')" :rows="3" />
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <x-form.input label="Harga (Rp)" name="price" type="number" min="0" step="1000" :value="old('price', $service->price ?? '')" required />
                    <x-form.input label="Satuan" name="unit" :value="old('unit', $service->unit ?? 'kg')" required placeholder="kg, pasang, pcs, dll" />
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <x-form.input label="Icon" name="icon" :value="old('icon', $service->icon ?? '')" hint="Nama icon (opsional)" />
                    <x-form.input label="Urutan" name="sort_order" type="number" min="0" :value="old('sort_order', $service->sort_order ?? 0)" />
                </div>
                <div class="mt-4">
                    <x-form.checkbox label="Aktif" name="is_active" :checked="old('is_active', $service->is_active ?? true)" />
                </div>
            </x-ui.card>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Layanan' }}
                </button>
                <a href="{{ route('admin.services.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
            </div>
        </div>
    </form>
</x-admin-layout>
