@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $menuItems = [
        [
            'section' => 'MENU',
            'items' => [
                ['name' => 'Dashboard', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>', 'route' => 'admin.dashboard'],
            ],
        ],
        [
            'section' => 'CABANG',
            'items' => [
                ['name' => 'Semua Cabang', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>', 'route' => 'admin.branches.index'],
                ['name' => 'Tambah Cabang', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>', 'route' => 'admin.branches.create'],
            ],
        ],
        [
            'section' => 'KONTEN',
            'items' => [
                ['name' => 'Artikel', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>', 'route' => 'admin.articles.index'],
                ['name' => 'Kategori Artikel', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6z"/></svg>', 'route' => 'admin.article-categories.index'],
                ['name' => 'Galeri', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>', 'route' => 'admin.galleries.index'],
            ],
        ],
        [
            'section' => 'LAYANAN',
            'items' => [
                ['name' => 'Layanan & Harga', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6z"/></svg>', 'route' => 'admin.services.index'],
                ['name' => 'Promo', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>', 'route' => 'admin.promotions.index'],
            ],
        ],
        [
            'section' => 'INTERAKSI',
            'items' => [
                ['name' => 'Testimoni', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>', 'route' => 'admin.testimonials.index'],
                ['name' => 'FAQ', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>', 'route' => 'admin.faqs.index'],
                ['name' => 'Pengecekan Lokasi', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>', 'route' => 'admin.location-checks.index'],
            ],
        ],
        [
            'section' => 'PENGATURAN',
            'items' => [
                ['name' => 'SEO Settings', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>', 'route' => 'admin.seo-settings.index'],
                ['name' => 'Pengaturan Umum', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0zm0 0l-1.5 1.5m0 0l-1.5-1.5m1.5 1.5v-1.5m0 1.5H3m18 0l-1.5-1.5m0 0l-1.5 1.5m1.5-1.5v1.5m0-1.5h1.5m-1.5 1.5v-1.5"/></svg>', 'route' => 'admin.settings.index'],
            ],
        ],
    ];
@endphp

<aside class="fixed left-0 top-0 z-9999 flex h-screen flex-col overflow-y-hidden border-r border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 transition-all duration-300 ease-in-out w-[290px]"
       :class="{
           'translate-x-0': sidebarOpen,
           '-translate-x-full': !sidebarOpen,
           'xl:translate-x-0': true,
       }"
       :style="window.innerWidth >= 1280 && !sidebarExpanded ? 'width: 90px' : ''"
       x-cloak>

    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
            </div>
            <span :class="sidebarExpanded ? '' : 'xl:hidden'" class="text-sm font-bold tracking-tight whitespace-nowrap">
                <span class="text-gray-800 dark:text-white">ISTANA</span>
                <span class="text-brand-500">LAUNDRY</span>
            </span>
        </a>
        <button @click="closeSidebar" class="xl:hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-3 py-4 custom-scrollbar">
        @foreach($menuItems as $group)
            <div class="mb-4">
                <div class="px-3 py-2">
                    <span :class="sidebarExpanded ? '' : 'xl:hidden'" class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ $group['section'] }}</span>
                </div>
                <ul class="space-y-1">
                    @foreach($group['items'] as $item)
                        <li>
                            @if(isset($item['route']) && Route::has($item['route']))
                                @php
                                    $active = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*');
                                @endphp
                                <a href="{{ route($item['route']) }}"
                                   class="menu-item {{ $active ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="sidebarExpanded || window.innerWidth < 1280 ? '' : 'xl:justify-center'"
                                   title="{{ $item['name'] }}">
                                    <span class="menu-item-icon {{ $active ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }} shrink-0">{!! $item['icon'] !!}</span>
                                    <span :class="sidebarExpanded ? '' : 'xl:hidden'">{{ $item['name'] }}</span>
                                    @if(!empty($item['badge']))
                                        <span :class="sidebarExpanded ? '' : 'xl:hidden'" class="menu-dropdown-badge">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            @else
                                <span class="menu-item menu-item-inactive opacity-50 cursor-not-allowed"
                                      :class="sidebarExpanded || window.innerWidth < 1280 ? '' : 'xl:justify-center'">
                                    <span class="menu-item-icon menu-item-icon-inactive shrink-0">{!! $item['icon'] !!}</span>
                                    <span :class="sidebarExpanded ? '' : 'xl:hidden'">{{ $item['name'] }}</span>
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div :class="sidebarExpanded ? '' : 'xl:hidden'" class="border-t border-gray-200 dark:border-gray-800 p-4">
        <div class="rounded-xl bg-brand-50 dark:bg-brand-950/30 p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-theme-sm font-semibold text-gray-800 dark:text-white whitespace-nowrap">Need Help?</span>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Hubungi admin</p>
                </div>
            </div>
            <a href="https://wa.me/628115599199" target="_blank" class="flex items-center justify-center gap-2 w-full rounded-lg bg-brand-500 text-white text-theme-sm font-medium px-4 py-2 hover:bg-brand-600 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                </svg>
                WA Admin
            </a>
        </div>
    </div>
</aside>
