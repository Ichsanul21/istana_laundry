@php $isEdit = isset($promotion); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Promo' : 'Tambah Promo' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Promo' : 'Tambah Promo' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.promotions.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Promo</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.promotions.update', $promotion) : route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-ui.card title="Informasi Promo">
                    <x-form.input label="Judul Promo" name="title" :value="old('title', $promotion->title ?? '')" required />
                    <div class="mt-4">
                        <x-form.input label="Slug" name="slug" :value="old('slug', $promotion->slug ?? '')" hint="Kosongkan untuk auto-generate" />
                    </div>
                    <div class="mt-4">
                        <x-form.textarea label="Deskripsi" name="description" :value="old('description', $promotion->description ?? '')" :rows="4" />
                    </div>
                </x-ui.card>

                <x-ui.card title="Gambar Promo">
                    <div class="flex items-start gap-4">
                        @if($isEdit && $promotion->image)
                            <img src="{{ asset('storage/' . $promotion->image) }}" alt="" class="w-32 h-32 rounded-lg object-cover">
                        @endif
                        <div class="flex-1">
                            <input type="file" name="image" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-500 hover:file:bg-brand-100 dark:file:bg-brand-950/30 dark:file:text-brand-400 dark:hover:file:bg-brand-950/50 transition-colors cursor-pointer">
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Maks 2MB. Format: JPG, PNG, WebP</p>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card title="Detail Diskon">
                    <x-form.select label="Tipe Diskon" name="discount_type" :options="['percent' => 'Persentase (%)', 'fixed' => 'Nominal (Rp)']" :value="old('discount_type', $promotion->discount_type ?? 'percent')" required />
                    <div class="mt-4">
                        <x-form.input label="Nilai Diskon" name="discount_value" type="number" min="0" step="100" :value="old('discount_value', $promotion->discount_value ?? '')" required />
                    </div>
                </x-ui.card>

                <x-ui.card title="Periode Promo">
                    <x-form.input label="Tanggal Mulai" name="start_date" type="date" :value="old('start_date', isset($promotion) && $promotion->start_date ? $promotion->start_date->format('Y-m-d') : '')" required />
                    <div class="mt-4">
                        <x-form.input label="Tanggal Berakhir" name="end_date" type="date" :value="old('end_date', isset($promotion) && $promotion->end_date ? $promotion->end_date->format('Y-m-d') : '')" required />
                    </div>
                    <div class="mt-4">
                        <x-form.checkbox label="Aktif" name="is_active" :checked="old('is_active', $promotion->is_active ?? true)" />
                    </div>
                </x-ui.card>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Promo' }}
                    </button>
                    <a href="{{ route('admin.promotions.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
