<header class="sticky top-0 flex w-full bg-white border-b border-gray-200 z-99999 dark:border-gray-800 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-between grow xl:flex-row xl:px-6">
        <div class="flex items-center justify-between w-full gap-2 px-3 py-3 border-b border-gray-200 dark:border-gray-800 sm:gap-4 xl:justify-normal xl:border-b-0 xl:px-0 xl:py-4">
            <button @click="toggleSidebar"
                    class="flex items-center justify-center w-10 h-10 text-gray-500 border border-gray-200 rounded-lg dark:border-gray-800 dark:text-gray-400 lg:h-11 lg:w-11 hover:bg-gray-100 dark:hover:bg-white/[0.03] transition-colors">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <div class="xl:hidden">
                <span class="text-sm font-bold tracking-tight">
                    <span class="text-gray-800 dark:text-white">ISTANA</span>
                    <span class="text-brand-500">LAUNDRY</span>
                </span>
            </div>

            <div class="flex items-center gap-3">
                <button @click="toggleDarkMode()"
                        class="flex items-center justify-center w-10 h-10 text-gray-500 border border-gray-200 rounded-lg dark:border-gray-800 dark:text-gray-400 lg:h-11 lg:w-11 hover:bg-gray-100 dark:hover:bg-white/[0.03] transition-colors">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                    </svg>
                </button>

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.03] transition-colors">
                            <div class="w-9 h-9 rounded-full bg-brand-500 flex items-center justify-center text-white text-sm font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden xl:block text-left">
                                <div class="text-theme-sm font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-theme-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <svg class="hidden xl:block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 rounded-xl border border-gray-200 bg-white shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 z-9999" x-cloak>
                            <div class="p-3 border-b border-gray-100 dark:border-gray-800">
                                <div class="text-theme-sm font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-theme-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="p-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 text-theme-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
