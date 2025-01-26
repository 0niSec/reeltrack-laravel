@props(['heading', 'href'])

<div {{ $attributes->class(['border-b border-primary-600 mb-2']) }}>
    <div class="mb-1 flex flex-row justify-between">
        <a href="{{ $href }}" class="text-primary-500 text-sm hover:text-primary-300 transition-colors cursor-pointer">
            {{ Str::upper($heading) }}
        </a>
        <a href="{{ $href }}" class="text-primary-500 text-sm hover:text-primary-300 transition-colors cursor-pointer">More...</a>
    </div>
</div>
