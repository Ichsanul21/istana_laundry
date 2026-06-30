<x-admin-layout>
    <x-slot:title>Galeri</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Galeri</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Galeri</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <div class="flex items-center justify-between mb-4">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total {{ $galleries->count() }} galeri</p>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Galeri
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                @if($gallery->images->count() > 0)
                    <img src="{{ asset('storage/' . $gallery->images->first()->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">{{ $gallery->title }}</h3>
                        <x-ui.badge :color="$gallery->is_active ? 'success' : 'error'" size="sm">{{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }}</x-ui.badge>
                    </div>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400 mb-3">{{ $gallery->images->count() }} foto</p>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 text-theme-xs font-medium text-brand-500 bg-brand-50 rounded-lg hover:bg-brand-100 dark:bg-brand-950/30 dark:hover:bg-brand-950/50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            Kelola
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus galeri ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 text-theme-xs font-medium text-error-500 bg-error-50 rounded-lg hover:bg-error-100 dark:bg-error-950/30 dark:hover:bg-error-950/50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                Belum ada galeri. <a href="{{ route('admin.galleries.create') }}" class="text-brand-500 hover:underline">Tambah galeri pertama</a>.
            </div>
        @endforelse
    </div>
</x-admin-layout>
