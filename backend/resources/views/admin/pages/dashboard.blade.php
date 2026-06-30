<x-admin-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Dashboard</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-center w-12 h-12 bg-brand-50 rounded-xl dark:bg-brand-950/30">
                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <div class="flex items-end justify-between mt-5">
                    <div>
                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">Total Cabang</span>
                        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $totalBranches ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-light-50 rounded-xl dark:bg-blue-light-950/30">
                    <svg class="w-6 h-6 text-blue-light-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <div class="flex items-end justify-between mt-5">
                    <div>
                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">Artikel</span>
                        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $totalArticles ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-center w-12 h-12 bg-success-50 rounded-xl dark:bg-success-950/30">
                    <svg class="w-6 h-6 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                    </svg>
                </div>
                <div class="flex items-end justify-between mt-5">
                    <div>
                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">Galeri</span>
                        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $totalGalleries ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-center w-12 h-12 bg-warning-50 rounded-xl dark:bg-warning-950/30">
                    <svg class="w-6 h-6 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                    </svg>
                </div>
                <div class="flex items-end justify-between mt-5">
                    <div>
                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">Pengecekan Hari Ini</span>
                        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $todayChecks ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-4">Aktivitas Terkini</h3>
        <div class="text-theme-sm text-gray-500">
            @if(isset($recentChecks) && count($recentChecks) > 0)
                <ul class="space-y-3">
                    @foreach($recentChecks as $check)
                        <li class="flex items-center gap-3 pb-3 border-b border-gray-100 dark:border-gray-800 last:border-0">
                            <div class="w-8 h-8 rounded-full bg-brand-50 dark:bg-brand-950/30 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="font-medium text-gray-800 dark:text-white/90">{{ $check->name }}</span>
                                <span class="text-gray-500"> — {{ $check->nearestBranch?->name ?? '-' }} ({{ number_format($check->distance_km, 2) }} km)</span>
                            </div>
                            <span class="text-theme-xs text-gray-400">{{ $check->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="py-8 text-center">Belum ada aktivitas pengecekan.</p>
            @endif
        </div>
    </div>
</x-admin-layout>
