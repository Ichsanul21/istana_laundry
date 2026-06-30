<x-admin-layout>
    <x-slot:title>Artikel</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Artikel</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Artikel</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau konten..."
                   class="h-11 flex-1 min-w-[200px] rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
            <select name="status" class="h-11 w-40 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            </select>
            <button type="submit" class="h-11 px-5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">Filter</button>
            <a href="{{ route('admin.articles.index') }}" class="h-11 px-5 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">Reset</a>
        </form>
    </x-ui.card>

    <div class="flex items-center justify-between mb-4">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total {{ $articles->total() }} artikel</p>
        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Artikel
        </a>
    </div>

    <x-ui.table :headers="['Judul', 'Kategori', 'Penulis', 'Status', 'Tanggal', 'Aksi']">
        @forelse($articles as $article)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                        @endif
                        <div>
                            <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90 block">{{ Str::limit($article->title, 50) }}</span>
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ $article->slug }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $article->category?->name ?? '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $article->author }}</span>
                </td>
                <td class="px-5 py-3">
                    @php
                        $statusColors = ['draft' => 'warning', 'published' => 'success', 'scheduled' => 'info'];
                        $statusLabels = ['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled'];
                    @endphp
                    <x-ui.badge :color="$statusColors[$article->status]" size="sm">{{ $statusLabels[$article->status] }}</x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $article->published_at?->format('d/m/Y') ?? '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </a>
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-400 transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada artikel.</td></tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">{{ $articles->links('vendor.pagination.tailwind') }}</div>
</x-admin-layout>
