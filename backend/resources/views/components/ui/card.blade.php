@props([
    'title' => null,
    'description' => null,
    'class' => '',
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] ' . $class]) }}>
    @if($title || $description)
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            @if($title)
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
            @endif
        </div>
    @endif
    <div class="{{ $padding ? 'p-4 sm:p-6' : '' }}">
        {{ $slot }}
    </div>
</div>
