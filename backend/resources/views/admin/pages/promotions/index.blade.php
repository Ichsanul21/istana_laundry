<x-admin-layout>
    <x-slot:title>Promo</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Promo & Diskon</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Promo</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <div class="flex items-center justify-between mb-4">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total {{ $promotions->count() }} promo</p>
        <a href="{{ route('admin.promotions.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Promo
        </a>
    </div>

    <x-ui.table :headers="['Judul', 'Tipe Diskon', 'Nilai', 'Periode', 'Status', 'Aksi']">
        @forelse($promotions as $promo)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                            </div>
                        @endif
                        <div>
                            <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90 block">{{ Str::limit($promo->title, 40) }}</span>
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ $promo->slug }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3">
                    <x-ui.badge :color="$promo->discount_type === 'percent' ? 'info' : 'warning'" size="sm">
                        {{ $promo->discount_type === 'percent' ? 'Persentase' : 'Nominal' }}
                    </x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                        @if($promo->discount_type === 'percent')
                            {{ $promo->discount_value }}%
                        @else
                            Rp{{ number_format($promo->discount_value, 0, ',', '.') }}
                        @endif
                    </span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">
                        {{ $promo->start_date->format('d/m/Y') }} - {{ $promo->end_date->format('d/m/Y') }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    @php
                        $now = now();
                        $isActive = $promo->is_active && $promo->start_date <= $now && $promo->end_date >= $now;
                    @endphp
                    <x-ui.badge :color="$isActive ? 'success' : 'error'" size="sm">{{ $isActive ? 'Aktif' : 'Nonaktif' }}</x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.promotions.edit', $promo) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </a>
                        <form action="{{ route('admin.promotions.destroy', $promo) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-400 transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada promo.</td></tr>
        @endforelse
    </x-ui.table>
</x-admin-layout>
