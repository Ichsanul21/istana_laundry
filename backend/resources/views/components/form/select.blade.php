@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'options' => [],
    'placeholder' => 'Pilih...',
    'value' => '',
    'error' => null,
    'disabled' => false,
    'required' => false,
])

@php
    $inputId = $id ?? $name;
    $errorKey = $name ? str_replace(['[', ']'], ['.', ''], $name) : null;
    $hasError = $error ?? ($name && $errors->has($errorKey));
    $errorMessage = $error ?? ($name ? $errors->first($errorKey) : null);
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:model')->except(['class']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
            @if($required) <span class="text-error-500">*</span> @endif
        </label>
    @endif

    <div class="relative">
        <select id="{{ $inputId }}"
                name="{{ $name }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->whereStartsWith('wire:model') }}
                @class([
                    'h-11 w-full rounded-lg border px-4 py-2.5 pr-11 text-sm shadow-theme-xs appearance-none focus:outline-hidden focus:ring-3 transition-colors duration-200',
                    'border-gray-300 focus:border-brand-300 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90' => !$hasError,
                    'border-error-500 focus:border-error-300 focus:ring-error-500/20 dark:border-error-500' => $hasError,
                    'text-gray-500 border-gray-300 opacity-40 bg-gray-100 cursor-not-allowed dark:bg-gray-800' => $disabled,
                ])>
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" {{ old($name, $value) == $optValue ? 'selected' : '' }}>{{ $optLabel }}</option>
            @endforeach
        </select>
        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
        </span>
    </div>

    @if($hasError && $errorMessage)
        <p class="mt-1 text-theme-xs text-error-500">{{ $errorMessage }}</p>
    @endif
</div>
