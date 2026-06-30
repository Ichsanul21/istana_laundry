@php $isEdit = isset($gallery); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Galeri' : 'Tambah Galeri' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Galeri' : 'Tambah Galeri' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li><a href="{{ route('admin.galleries.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Galeri</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-ui.card title="Informasi Galeri">
                    <x-form.input label="Judul" name="title" :value="old('title', $gallery->title ?? '')" required />
                    <div class="mt-4">
                        <x-form.input label="Slug" name="slug" :value="old('slug', $gallery->slug ?? '')" hint="Kosongkan untuk auto-generate" />
                    </div>
                    <div class="mt-4">
                        <x-form.textarea label="Deskripsi" name="description" :value="old('description', $gallery->description ?? '')" :rows="3" />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <x-form.input label="Urutan" name="sort_order" type="number" min="0" :value="old('sort_order', $gallery->sort_order ?? 0)" />
                        <div class="flex items-end">
                            <x-form.checkbox label="Aktif" name="is_active" :checked="old('is_active', $gallery->is_active ?? true)" />
                        </div>
                    </div>
                </x-ui.card>

                @if(!$isEdit)
                    <x-ui.card title="Upload Foto">
                        <input type="file" name="images[]" accept="image/*" multiple
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-500 hover:file:bg-brand-100 dark:file:bg-brand-950/30 dark:file:text-brand-400 dark:hover:file:bg-brand-950/50 transition-colors cursor-pointer">
                        <p class="mt-2 text-theme-xs text-gray-500 dark:text-gray-400">Pilih beberapa foto sekaligus. Maksimal 2MB per foto.</p>
                    </x-ui.card>
                @endif
            </div>

            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Galeri' }}
                    </button>
                    <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Batal</a>
                </div>
            </div>
        </div>
    </form>

    @if($isEdit && $gallery->images->count() > 0)
        <div class="mt-6">
            <x-ui.card title="Foto Galeri ({{ $gallery->images->count() }} foto)">
                <p class="text-theme-xs text-gray-500 dark:text-gray-400 mb-4">Drag & drop untuk mengubah urutan foto.</p>
                <div id="gallery-images" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($gallery->images as $image)
                        <div class="gallery-image-item relative group rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800" data-id="{{ $image->id }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text }}" class="w-full h-32 object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="deleteImage({{ $image->id }})" class="p-2 bg-error-500 text-white rounded-lg hover:bg-error-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </div>
                            <div class="p-2 bg-white dark:bg-gray-900">
                                <p class="text-theme-xs text-gray-500 dark:text-gray-400 truncate">{{ $image->caption ?? 'No caption' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-ui.card>
        </div>
    @endif

    @push('scripts')
    <script>
        function deleteImage(imageId) {
            if (!confirm('Yakin ingin menghapus foto ini?')) return;
            fetch('{{ route("admin.galleries.index") }}/' + imageId, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(r => r.json()).then(() => location.reload());
        }
    </script>
    @endpush
</x-admin-layout>
