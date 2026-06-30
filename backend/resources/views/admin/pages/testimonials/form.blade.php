@php $isEdit = isset($testimonial); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Testimoni' : 'Tambah Testimoni' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.testimonials.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Testimoni</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="max-w-2xl">
            <x-ui.card title="Informasi Testimoni">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.input label="Nama Pelanggan" name="customer_name" :value="old('customer_name', $testimonial->customer_name ?? '')" required />
                    <x-form.input label="Jabatan/Profesi" name="customer_title" :value="old('customer_title', $testimonial->customer_title ?? '')" placeholder="Ibu Rumah Tangga, Mahasiswa, dll" />
                </div>
                <div class="mt-4">
                    <label for="rating" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Rating <span class="text-error-500">*</span></label>
                    <div class="flex items-center gap-1" id="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="rating-star" data-value="{{ $i }}">
                                <svg class="w-8 h-8 transition-colors {{ $i <= (old('rating', $testimonial->rating ?? 5)) ? 'text-warning-500' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ old('rating', $testimonial->rating ?? 5) }}">
                </div>
                <div class="mt-4">
                    <x-form.textarea label="Ucapan Testimoni" name="body" :value="old('body', $testimonial->body ?? '')" :rows="4" required />
                </div>
                <div class="mt-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Foto Avatar</label>
                    <div class="flex items-start gap-4">
                        @if($isEdit && $testimonial->avatar)
                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" class="w-16 h-16 rounded-full object-cover">
                        @endif
                        <div class="flex-1">
                            <input type="file" name="avatar" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-500 hover:file:bg-brand-100 dark:file:bg-brand-950/30 dark:file:text-brand-400 dark:hover:file:bg-brand-950/50 transition-colors cursor-pointer">
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Maks 2MB. Opsional.</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <x-form.input label="Urutan" name="sort_order" type="number" min="0" :value="old('sort_order', $testimonial->sort_order ?? 0)" />
                    <div class="flex items-end">
                        <x-form.checkbox label="Aktif" name="is_active" :checked="old('is_active', $testimonial->is_active ?? true)" />
                    </div>
                </div>
            </x-ui.card>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Testimoni' }}
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        function setRating(value) {
            document.getElementById('rating').value = value;
            document.querySelectorAll('.rating-star').forEach(star => {
                const v = parseInt(star.dataset.value);
                const svg = star.querySelector('svg');
                if (v <= value) {
                    svg.classList.remove('text-gray-300', 'dark:text-gray-600');
                    svg.classList.add('text-warning-500');
                } else {
                    svg.classList.remove('text-warning-500');
                    svg.classList.add('text-gray-300', 'dark:text-gray-600');
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>
