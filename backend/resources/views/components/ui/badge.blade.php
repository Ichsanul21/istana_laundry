@props([
    'variant' => 'light',
    'size' => 'sm',
    'color' => 'primary',
    'startIcon' => null,
    'endIcon' => null,
])

@php
    $baseClasses = 'inline-flex items-center px-2.5 py-0.5 justify-center gap-1 rounded-full font-medium';

    $colorClassesLight = [
        'primary' => 'bg-brand-50 text-brand-500 dark:bg-brand-950/30 dark:text-brand-400',
        'success' => 'bg-success-50 text-success-600 dark:bg-success-950/30 dark:text-success-400',
        'error' => 'bg-error-50 text-error-600 dark:bg-error-950/30 dark:text-error-400',
        'warning' => 'bg-warning-50 text-warning-600 dark:bg-warning-950/30 dark:text-warning-400',
        'info' => 'bg-blue-light-50 text-blue-light-600 dark:bg-blue-light-950/30 dark:text-blue-light-400',
        'dark' => 'bg-gray-800 text-white dark:bg-gray-700 dark:text-gray-300',
    ];

    $colorClassesSolid = [
        'primary' => 'bg-brand-500 text-white',
        'success' => 'bg-success-500 text-white',
        'error' => 'bg-error-500 text-white',
        'warning' => 'bg-warning-500 text-white',
        'info' => 'bg-blue-light-500 text-white',
        'dark' => 'bg-gray-800 text-white',
    ];

    $sizeClasses = [
        'sm' => 'text-theme-xs',
        'md' => 'text-theme-sm',
    ][$size] ?? 'text-theme-xs';

    $colorClasses = $variant === 'solid' ? ($colorClassesSolid[$color] ?? $colorClassesSolid['primary']) : ($colorClassesLight[$color] ?? $colorClassesLight['primary']);

    $allClasses = "$baseClasses $sizeClasses $colorClasses";
@endphp

<span {{ $attributes->merge(['class' => $allClasses]) }}>
    @if($startIcon)
        <span class="flex-shrink-0">{!! $startIcon !!}</span>
    @endif
    {{ $slot }}
    @if($endIcon)
        <span class="flex-shrink-0">{!! $endIcon !!}</span>
    @endif
</span>
