@props([
    'paginator' => null,
])

@if($paginator && $paginator->hasPages())
    <div {{ $attributes->merge(['class' => 'flex items-center justify-between gap-8 px-6 py-4']) }}>
        <div class="flex items-center gap-2">
            @if($paginator->onFirstPage())
                <span class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2.5 text-sm font-medium text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-brand-500 hover:text-white dark:hover:bg-brand-500 transition-colors">
                    Previous
                </a>
            @endif
        </div>

        <div class="hidden sm:flex items-center gap-1">
            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-brand-500 text-white text-sm font-medium">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-brand-500 hover:text-white dark:hover:bg-brand-500 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-brand-500 hover:text-white dark:hover:bg-brand-500 transition-colors">
                    Next
                </a>
            @else
                <span class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2.5 text-sm font-medium text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </div>
@endif
