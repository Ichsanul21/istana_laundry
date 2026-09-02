<x-admin-layout>
    <x-slot:title>Detail Pengecekan Karpet</x-slot:title>

    @php
        $conditionColors = ['Baik' => 'success', 'Buruk' => 'error'];
        $severityColors = ['parah' => 'error', 'ringan' => 'warning'];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Detail Pengecekan Karpet</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li>
                    <a href="{{ route('admin.carpet-inspections.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Pengecekan Karpet</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-ui.card title="Foto Karpet">
                <a href="{{ $inspection->photo_url }}" target="_blank" class="block overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <img src="{{ $inspection->photo_url }}" alt="Foto karpet" class="w-full object-cover">
                </a>
            </x-ui.card>

            <x-ui.card title="Informasi Pelanggan">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Nama</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $inspection->name }}</p>
                    </div>
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">WhatsApp</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                            <a href="https://wa.me/{{ $inspection->wa_number }}" target="_blank" class="text-brand-500 hover:underline">{{ $inspection->whatsapp }}</a>
                        </p>
                    </div>
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Tanggal Pengecekan</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $inspection->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Link Hasil Publik</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                            <a href="{{ route('karpet.show', $inspection->token) }}" target="_blank" class="text-brand-500 hover:underline">Buka</a>
                        </p>
                    </div>
                    @if($inspection->notes)
                        <div class="md:col-span-2">
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">Catatan Pelanggan</span>
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $inspection->notes }}</p>
                        </div>
                    @endif
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card title="Hasil Diagnosa AI">
                @if($inspection->status === 'completed')
                    <div class="text-center py-2">
                        <span class="text-5xl font-bold text-gray-800 dark:text-white/90">{{ $inspection->cleanliness_score }}%</span>
                        <div class="mt-3 flex items-center justify-center gap-2">
                            <x-ui.badge :color="$conditionColors[$inspection->overall_condition] ?? 'warning'">{{ $inspection->overall_condition }}</x-ui.badge>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach($inspection->findings ?? [] as $finding)
                            <div class="flex items-start gap-2 py-2 border-b border-gray-100 dark:border-gray-800 last:border-0">
                                <div class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0 {{ $finding['severity'] === 'parah' ? 'bg-error-500' : ($finding['severity'] === 'sedang' ? 'bg-brand-500' : 'bg-warning-500') }}"></div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $finding['label'] }}</span>
                                        <x-ui.badge :color="$severityColors[$finding['severity']] ?? 'primary'" size="sm">{{ ucfirst($finding['severity']) }}</x-ui.badge>
                                    </div>
                                    @if(!empty($finding['description']))
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400 mt-1">{{ $finding['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($inspection->status === 'failed')
                    <div class="text-center py-4">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-error-50 dark:bg-error-950/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <x-ui.badge color="error">Gagal</x-ui.badge>
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400 mt-3">{{ $inspection->error_message ?? 'Analisa gagal diproses.' }}</p>
                    </div>
                @else
                    <div class="text-center py-4">
                        <x-ui.badge color="warning">Processing</x-ui.badge>
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400 mt-3">Pengecekan sedang diproses.</p>
                    </div>
                @endif
            </x-ui.card>

            @if($inspection->status === 'completed')
                <x-ui.card title="Ringkasan & Rekomendasi">
                    @if($inspection->summary)
                        <p class="text-theme-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $inspection->summary }}</p>
                    @endif
                    @if($inspection->recommendation)
                        <div class="mt-4 p-3 rounded-lg bg-brand-50 dark:bg-brand-950/30 border border-brand-100 dark:border-brand-900">
                            <p class="text-theme-sm text-gray-700 dark:text-gray-300">{{ $inspection->recommendation }}</p>
                        </div>
                    @endif
                </x-ui.card>
            @endif

            @if($inspection->raw_response)
                <x-ui.card title="Respons Mentah (AI)">
                    <details class="group">
                        <summary class="cursor-pointer text-theme-sm font-medium text-brand-500 hover:text-brand-600 transition-colors">
                            Tampilkan JSON
                        </summary>
                        <pre class="mt-3 p-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-theme-xs text-gray-700 dark:text-gray-300 overflow-x-auto leading-relaxed">{{ $inspection->raw_response }}</pre>
                    </details>
                </x-ui.card>
            @endif

            <a href="{{ route('admin.carpet-inspections.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</x-admin-layout>