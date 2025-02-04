<div>
    <label class="block text-sm text-primary-400 mb-1">{{ $is_watched ? 'Watched' : 'Watch' }}</label>
    <input type="hidden" name="like" wire:model.live="is_watched">
    <div class="relative flex items-center group">
        <div class="cursor-pointer" wire:click.prevent="toggleWatch">
            <x-icon-eye-outline
                class="w-8 h-8 text-primary-600 hover:text-primary-400 hover:fill-primary-500 transition-colors"/>
        </div>
    </div>
</div>
