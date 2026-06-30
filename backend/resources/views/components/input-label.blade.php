@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[11px] font-mono tracking-wider uppercase text-black/60']) }}>
    {{ $value ?? $slot }}
</label>
