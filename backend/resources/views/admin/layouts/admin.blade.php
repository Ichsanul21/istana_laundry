<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    @stack('styles')
</head>
<body class="font-outfit antialiased bg-gray-50 dark:bg-gray-950">

<div class="min-h-screen xl:flex" x-data="adminLayout()" x-init="init()">
    <x-admin.sidebar />
    <div class="fixed inset-0 z-50 bg-gray-900/50 dark:bg-gray-900/80 xl:hidden" x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:leave="transition-opacity ease-linear duration-300" x-cloak></div>

    <div class="flex-1 transition-all duration-300 ease-in-out" :class="{'xl:ml-[290px]': sidebarExpanded, 'xl:ml-[90px]': !sidebarExpanded}">
        <x-admin.header />

        <main class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            @yield('content')
        </main>

        <footer class="border-t border-gray-200 dark:border-gray-800 py-4 px-6">
            <div class="flex items-center justify-between">
                <span class="text-theme-xs text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
                <span class="text-theme-xs text-gray-400">Powered by Alenkosa</span>
            </div>
        </footer>
    </div>
</div>

<script>
    function adminLayout() {
        return {
            sidebarOpen: false,
            sidebarExpanded: true,
            darkMode: localStorage.getItem('theme') === 'dark',
            init() {
                this.sidebarExpanded = localStorage.getItem('sidebarExpanded') !== 'false';
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                }
            },
            toggleSidebar() {
                if (window.innerWidth >= 1280) {
                    this.sidebarExpanded = !this.sidebarExpanded;
                    localStorage.setItem('sidebarExpanded', this.sidebarExpanded);
                } else {
                    this.sidebarOpen = !this.sidebarOpen;
                }
            },
            closeSidebar() {
                this.sidebarOpen = false;
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            }
        }
    }
</script>

@stack('scripts')
</body>
</html>
