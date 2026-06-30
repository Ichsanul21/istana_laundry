<x-admin-layout>
    <x-slot:title>Cabang</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Cabang</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Cabang</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <div class="flex items-center justify-between mb-4">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total {{ $branches->count() }} cabang</p>
        <a href="{{ route('admin.branches.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Cabang
        </a>
    </div>

    <x-ui.table :headers="['No', 'Nama Cabang', 'Tipe', 'Alamat', 'Koordinat', 'Radius', 'Status', 'Aksi']">
        @forelse($branches as $branch)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3 text-theme-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $branch->name }}</span>
                    @if($branch->phone)
                        <span class="block text-theme-xs text-gray-500">{{ $branch->phone }}</span>
                    @endif
                </td>
                <td class="px-5 py-3">
                    <x-ui.badge :color="$branch->type === 'workshop' ? 'warning' : 'primary'" size="sm">
                        {{ ucfirst($branch->type) }}
                    </x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400 max-w-xs truncate block">{{ $branch->address }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400 font-mono text-xs">{{ number_format($branch->lat, 7) }}, {{ number_format($branch->lng, 7) }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $branch->radius_km }} km</span>
                </td>
                <td class="px-5 py-3">
                    <x-ui.badge :color="$branch->is_active ? 'success' : 'error'" size="sm">
                        {{ $branch->is_active ? 'Aktif' : 'Nonaktif' }}
                    </x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.branches.edit', $branch) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-400 transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    Belum ada cabang. <a href="{{ route('admin.branches.create') }}" class="text-brand-500 hover:underline">Tambah cabang pertama</a>.
                </td>
            </tr>
        @endforelse
    </x-ui.table>
</x-admin-layout>
