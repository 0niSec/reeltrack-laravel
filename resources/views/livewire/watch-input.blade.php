<div>
    <label class="block text-sm text-primary-400 mb-1">{{ $isWatched ? 'Watched' : 'Watch' }}</label>
    <div class="relative flex items-center group">
        <div class="cursor-pointer " wire:click="toggleWatch"
        >
            <x-icon-eye-outline
                class="w-10 h-10 hover:text-primary-400 transition-colors {{
                $isWatched ? 'fill-primary-500 stroke-current text-zinc-950' : 'fill-none text-primary-500'
                 }}"/>
        </div>
    </div>
</div>
