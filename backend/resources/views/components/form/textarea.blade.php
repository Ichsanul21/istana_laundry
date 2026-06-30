@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'placeholder' => '',
    'value' => '',
    'rows' => 3,
    'error' => null,
    'hint' => null,
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

    <textarea id="{{ $inputId }}"
              name="{{ $name }}"
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              {{ $required ? 'required' : '' }}
              {{ $disabled ? 'disabled' : '' }}
              {{ $attributes->whereStartsWith('wire:model') }}
              @class([
                  'w-full rounded-lg border px-4 py-2.5 text-sm shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 transition-colors duration-200 resize-none',
                  'border-gray-300 focus:border-brand-300 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500' => !$hasError,
                  'border-error-500 focus:border-error-300 focus:ring-error-500/20 dark:border-error-500' => $hasError,
                  'text-gray-500 border-gray-300 opacity-40 bg-gray-100 cursor-not-allowed dark:bg-gray-800 dark:text-gray-500' => $disabled,
              ])>{{ old($name, $value) }}</textarea>

    @if($hint && !$hasError)
        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($hasError && $errorMessage)
        <p class="mt-1 text-theme-xs text-error-500">{{ $errorMessage }}</p>
    @endif
</div>
