@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'type' => 'button',
    'startIcon' => null,
    'endIcon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium gap-2 rounded-lg transition-all duration-200 focus:outline-none';

    $variantClasses = [
        'primary' => 'bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus:ring-2 focus:ring-brand-500/20',
        'outline' => 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-brand-500/20 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700',
        'danger' => 'bg-error-500 text-white shadow-theme-xs hover:bg-error-600 focus:ring-2 focus:ring-error-500/20',
        'success' => 'bg-success-500 text-white shadow-theme-xs hover:bg-success-600 focus:ring-2 focus:ring-success-500/20',
        'ghost' => 'text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/[0.03]',
    ][$variant] ?? 'bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600';

    $sizeClasses = [
        'sm' => 'px-4 py-3 text-theme-sm',
        'md' => 'px-5 py-3.5 text-theme-sm',
        'lg' => 'px-6 py-4 text-base',
    ][$size] ?? 'px-5 py-3.5 text-theme-sm';

    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer';
@endphp

<button type="{{ $type }}"
        {{ $attributes->merge(['class' => "$baseClasses $variantClasses $sizeClasses $disabledClasses"]) }}
        {{ $disabled ? 'disabled' : '' }}>
    @if($startIcon)
        <span class="flex-shrink-0">{!! $startIcon !!}</span>
    @endif
    {{ $slot }}
    @if($endIcon)
        <span class="flex-shrink-0">{!! $endIcon !!}</span>
    @endif
</button>
