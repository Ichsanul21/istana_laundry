@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $config = [
        'success' => [
            'border' => 'border-success-500',
            'bg' => 'bg-success-50 dark:bg-success-950/20',
            'icon' => 'text-success-500',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'error' => [
            'border' => 'border-error-500',
            'bg' => 'bg-error-50 dark:bg-error-950/20',
            'icon' => 'text-error-500',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>',
        ],
        'warning' => [
            'border' => 'border-warning-500',
            'bg' => 'bg-warning-50 dark:bg-warning-950/20',
            'icon' => 'text-warning-500',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>',
        ],
        'info' => [
            'border' => 'border-blue-light-500',
            'bg' => 'bg-blue-light-50 dark:bg-blue-light-950/20',
            'icon' => 'text-blue-light-500',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>',
        ],
    ][$type];
@endphp

<div x-data="{ visible: true, dismissed: false }"
     x-show="visible && !dismissed"
     x-cloak
     {{ $attributes->merge(['class' => 'rounded-xl border p-4 ' . $config['border'] . ' ' . $config['bg']]) }}>
    <div class="flex items-start gap-3">
        <span class="flex-shrink-0 {{ $config['icon'] }}">
            {!! $config['svg'] !!}
        </span>
        <div class="flex-1 min-w-0">
            @if($title)
                <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h4>
            @endif
            <div class="text-sm text-gray-500 dark:text-gray-400 {{ $title ? 'mt-1' : '' }}">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <button @click="dismissed = true" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif
    </div>
</div>
