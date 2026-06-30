<x-admin-layout>
    <x-slot:title>Testimoni</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Testimoni</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Testimoni</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <div class="flex items-center justify-between mb-4">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total {{ $testimonials->count() }} testimoni</p>
        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Testimoni
        </a>
    </div>

    <x-ui.table :headers="['No', 'Nama', 'Jabatan', 'Rating', 'Ucapan', 'Status', 'Aksi']">
        @forelse($testimonials as $testimonial)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-5 py-3 text-theme-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        @if($testimonial->avatar)
                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-brand-50 dark:bg-brand-950/30 flex items-center justify-center">
                                <span class="text-brand-500 font-bold text-sm">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $testimonial->customer_name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $testimonial->customer_title ?? '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-warning-500' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        @endfor
                    </div>
                </td>
                <td class="px-5 py-3">
                    <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ Str::limit($testimonial->body, 60) }}</span>
                </td>
                <td class="px-5 py-3">
                    <x-ui.badge :color="$testimonial->is_active ? 'success' : 'error'" size="sm">{{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}</x-ui.badge>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-400 transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada testimoni.</td></tr>
        @endforelse
    </x-ui.table>
</x-admin-layout>
