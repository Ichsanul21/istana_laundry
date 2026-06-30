@props([
    'isOpen' => false,
    'maxWidth' => 'max-w-lg',
    'title' => null,
])

<div x-data="{ isOpen: @json($isOpen) }"
     x-show="isOpen"
     x-cloak
     @keydown.escape.window="isOpen = false"
     class="relative z-99999">
    <div x-show="isOpen"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:leave="transition-opacity ease-in duration-150"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px] dark:bg-gray-900/80"
         @click="isOpen = false">
    </div>
    <div class="fixed inset-0 flex items-center justify-center overflow-y-auto">
        <div x-show="isOpen"
             x-transition:enter="transition-all ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition-all ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full {{ $maxWidth }} rounded-3xl bg-white dark:bg-gray-900 shadow-theme-xl p-5 lg:p-10 mx-4">
            <button @click="isOpen = false"
                    class="absolute top-3 right-3 flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            @if($title)
                <h4 class="font-semibold text-gray-800 dark:text-white/90 mb-7 text-title-sm">{{ $title }}</h4>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
