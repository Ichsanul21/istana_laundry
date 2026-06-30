@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
])

@php
    $inputId = $id ?? $name;
@endphp

<label {{ $attributes->except(['class'])->merge(['class' => 'flex items-center gap-2 cursor-pointer']) }}>
    <div class="relative">
        <input type="checkbox"
               id="{{ $inputId }}"
               name="{{ $name }}"
               value="{{ $value }}"
               {{ old($name, $checked) ? 'checked' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               class="sr-only peer">
        <div class="w-5 h-5 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 peer-checked:bg-brand-500 peer-checked:border-brand-500 peer-disabled:opacity-40 peer-disabled:cursor-not-allowed transition-colors duration-200">
            <svg class="w-full h-full text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>
    </div>
    @if($label)
        <span class="text-sm font-medium text-gray-700 dark:text-gray-400">{{ $label }}</span>
    @endif
</label>
