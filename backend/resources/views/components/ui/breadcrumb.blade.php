@props([
    'items' => [],
])

<nav {{ $attributes->merge(['class' => '']) }}>
    <ol class="flex items-center gap-1.5">
        @foreach($items as $item)
            <li>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500 dark:hover:text-brand-400 transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-theme-sm {{ $loop->last ? 'text-gray-800 dark:text-white/90 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
            @if(!$loop->last)
                <li class="text-theme-sm text-gray-400 dark:text-gray-500">/</li>
            @endif
        @endforeach
    </ol>
</nav>
