<div>
    <label class="block text-sm text-primary-400 mb-1">Watchlist</label>
    <div class="relative flex items-center group">
        <div class="cursor-pointer " wire:click="toggleWatchlist">
            <x-icon-clock
                class="w-10 h-10 hover:text-primary-400 transition-colors {{
                    $isWatchlisted ? 'fill-primary-500 stroke-current text-zinc-950' : 'fill-none text-primary-500'
                     }}"/>
        </div>
    </div>
</div>
