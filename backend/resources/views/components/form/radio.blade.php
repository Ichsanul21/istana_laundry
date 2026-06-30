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
        <input type="radio"
               id="{{ $inputId }}"
               name="{{ $name }}"
               value="{{ $value }}"
               {{ old($name, $checked) == $value ? 'checked' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               class="sr-only peer">
        <div class="w-5 h-5 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 peer-checked:border-brand-500 peer-checked:bg-brand-500 peer-disabled:opacity-40 peer-disabled:cursor-not-allowed transition-colors duration-200 flex items-center justify-center">
            <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
        </div>
    </div>
    @if($label)
        <span class="text-sm font-medium text-gray-700 dark:text-gray-400">{{ $label }}</span>
    @endif
</label>
