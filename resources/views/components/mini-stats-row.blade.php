@props(['stats'])

<div {{ $attributes->merge(['class' => "flex flex-row justify-center space-x-2 items-center"]) }}>
    <div class="flex items-center space-x-0.5">
        <x-icon-eye-filled class="w-5 h-5 cursor-pointer text-primary-500"/>
        <span class="text-xs text-zinc-400">{{ $stats->watchlists_count ?? 0 }}</span>
    </div>

    <div class="flex items-center space-x-0.5">
        <x-icon-list class="w-5 h-5 cursor-pointer text-primary-500"/>
        <span class="text-xs text-zinc-400">{{ $stats->lists_count ?? 0 }}</span>
    </div>

    <div class="flex items-center space-x-0.5">
        <x-icon-heart-filled class="w-5 h-5 cursor-pointer text-primary-500"/>
        <span class="text-xs text-zinc-400">{{ $stats->likes_count ?? 0 }}</span>
    </div>

</div>
