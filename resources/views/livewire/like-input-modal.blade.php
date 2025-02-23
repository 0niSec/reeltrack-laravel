<div>
    <label class="block text-sm text-primary-400 mb-1">{{ $isLiked ? 'Liked' : 'Like' }}</label>

    <div class="relative flex items-center group">
        <input type="hidden" name="isLiked" x-ref="isLiked" wire:model="isLiked" :value="$wire.isLiked"/>
        <div
            class="cursor-pointer relative"
            wire:click="toggleLike"
            wire:loading.class="opacity-50"
        >
            <x-icon-heart-outline
                class="w-10 h-10 hover:text-primary-400 transition-colors {{ $isLiked ? 'fill-primary-500 text-primary-500' : 'fill-none text-primary-500' }}"
            />

            <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <svg class="animate-spin w-4 h-4 text-primary-500" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>
