<x-admin-layout>
    <x-slot:title>Pengecekan Lokasi</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pengecekan Lokasi</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Pengecekan Lokasi</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route('admin.location-checks.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, WhatsApp, atau alamat..."
                       class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
            </div>
            <select name="status" class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
                <option value="">Semua Status</option>
                <option value="within" {{ request('status') === 'within' ? 'selected' : '' }}>Dalam Jangkauan</option>
                <option value="outside" {{ request('status') === 'outside' ? 'selected' : '' }}>Di Luar Jangkauan</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90"
                   placeholder="Dari tanggal">
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90"
                   placeholder="Sampai tanggal">
            <div class="flex items-center gap-2">
                <button type="submit" class="h-11 px-4 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.location-checks.index') }}" class="h-11 px-4 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </x-ui.card>

    <div class="flex items-center justify-between mb-4">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total {{ $checks->total() }} pengecekan</p>
        <a href="{{ route('admin.location-checks.export', request()->only(['date_from', 'date_to'])) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Export CSV
        </a>
    </div>

    <x-ui.table :headers="['Tanggal', 'Nama', 'WhatsApp', 'Alamat', 'Cabang Terdekat', 'Jarak', 'Status', 'Aksi']">
        @forelse($checks as $check)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3 text-theme-sm text-gray-500 dark:text-gray-400">{{ $check->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $check->name }}</span>
                </td>
                <td class="px-5 py-3">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $check->whatsapp) }}" target="_blank" class="text-theme-sm text-brand-500 hover:underline">{{ $check->whatsapp }}</a>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400 max-w-xs truncate block">{{ $check->address }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $check->nearestBranch?->name ?? '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ number_format($check->distance_km, 2) }} km</span>
                </td>
                <td class="px-5 py-3">
                    <x-ui.badge :color="$check->is_within_radius ? 'success' : 'error'" size="sm">
                        {{ $check->is_within_radius ? 'Dalam Jangkauan' : 'Di Luar Jangkauan' }}
                    </x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.location-checks.show', $check) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors" title="Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    Belum ada data pengecekan lokasi.
                </td>
            </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $checks->links('vendor.pagination.tailwind') }}
    </div>
</x-admin-layout>
