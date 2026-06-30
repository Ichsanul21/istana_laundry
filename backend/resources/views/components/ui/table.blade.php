@props([
    'headers' => [],
    'striped' => false,
    'hover' => true,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] ' . $class]) }}>
    <div class="max-w-full overflow-x-auto">
        <table class="min-w-full">
            @if(count($headers) > 0)
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        @foreach($headers as $header)
                            @php
                                $isFirst = $loop->first;
                                $isLast = $loop->last;
                            @endphp
                            <th class="px-5 py-3 font-medium text-gray-500 dark:text-gray-400 text-start text-theme-xs {{ $isFirst ? 'pl-5 sm:pl-6' : '' }} {{ $isLast ? 'pr-5 sm:pr-6' : '' }}">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
