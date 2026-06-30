<x-admin-layout>
    <x-slot:title>SEO Settings</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">SEO Settings</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">SEO Settings</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <p class="text-theme-sm text-gray-500 dark:text-gray-400 mb-4">Kelola meta tag dan Open Graph untuk setiap halaman.</p>

    <x-ui.table :headers="['Halaman', 'Meta Title', 'Schema Type', 'Aksi']">
        @forelse($seoSettings as $seo)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3">
                    <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ ucfirst(str_replace('-', ' ', $seo->page)) }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $seo->meta_title ?? '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    @if($seo->schema_type)
                        <x-ui.badge color="info" size="sm">{{ $seo->schema_type }}</x-ui.badge>
                    @else
                        <span class="text-theme-sm text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.seo-settings.edit', $seo) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-theme-xs font-medium text-brand-500 bg-brand-50 rounded-lg hover:bg-brand-100 dark:bg-brand-950/30 dark:hover:bg-brand-950/50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        Edit
                    </a>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada pengaturan SEO.</td></tr>
        @endforelse
    </x-ui.table>
</x-admin-layout>
