<x-admin-layout>
    <x-slot:title>Pengecekan Karpet</x-slot:title>

    @php
        $statusColors = ['processing' => 'warning', 'completed' => 'success', 'failed' => 'error'];
        $statusLabels = ['processing' => 'Processing', 'completed' => 'Selesai', 'failed' => 'Gagal'];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pengecekan Karpet</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Pengecekan Karpet</li>
            </ol>
        </nav>
    </div>

    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route('admin.carpet-inspections.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, WhatsApp, atau ringkasan..."
                       class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
            </div>
            <select name="status" class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
                <option value="">Semua Status</option>
                @foreach(['processing' => 'Processing', 'completed' => 'Selesai', 'failed' => 'Gagal'] as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="condition" class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-theme-xs focus:outline-hidden focus:ring-3 focus:border-brand-300 focus:ring-brand-500/20 transition-colors duration-200 dark:text-white/90">
                <option value="">Semua Kondisi</option>
                @foreach(['Baik', 'Sedang', 'Buruk'] as $condition)
                    <option value="{{ $condition }}" {{ request('condition') === $condition ? 'selected' : '' }}>{{ $condition }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-2">
                <button type="submit" class="h-11 px-4 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.carpet-inspections.index') }}" class="h-11 px-4 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </x-ui.card>

    <p class="text-theme-sm text-gray-500 dark:text-gray-400 mb-4">Total {{ $inspections->total() }} pengecekan</p>

    <x-ui.table :headers="['Tanggal', 'Nama', 'WhatsApp', 'Foto', 'Kondisi', 'Skor', 'Status', 'Aksi']">
        @forelse($inspections as $inspection)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3 text-theme-sm text-gray-500 dark:text-gray-400">{{ $inspection->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $inspection->name }}</span>
                </td>
                <td class="px-5 py-3">
                    <a href="https://wa.me/{{ $inspection->wa_number }}" target="_blank" class="text-theme-sm text-brand-500 hover:underline">{{ $inspection->whatsapp }}</a>
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.carpet-inspections.show', $inspection) }}">
                        <img src="{{ $inspection->photo_url }}" alt="Foto karpet" class="w-10 h-10 object-cover rounded border border-gray-200 dark:border-gray-700">
                    </a>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $inspection->overall_condition ?? '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm font-medium text-gray-700 dark:text-gray-300">{{ $inspection->cleanliness_score !== null ? $inspection->cleanliness_score . '%' : '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <x-ui.badge :color="$statusColors[$inspection->status]" size="sm">
                        {{ $statusLabels[$inspection->status] }}
                    </x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.carpet-inspections.show', $inspection) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors" title="Detail">
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
                    Belum ada data pengecekan karpet.
                </td>
            </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $inspections->links('vendor.pagination.tailwind') }}
    </div>
</x-admin-layout>