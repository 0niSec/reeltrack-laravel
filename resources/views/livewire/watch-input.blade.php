<div>
    <label class="block text-sm text-primary-400 mb-1">
        @if($hasUserReviews)
            <a href="{{ route('user.reviews', ['user' => auth()->user(),'movie' => $movie]) }}"
               class="hover:text-primary-600">
                Reviewed
            </a>
        @else
            {{ $isWatched ? 'Watched' : 'Watch' }}
        @endif
    </label>
    <input type="hidden" name="isWatched" wire:model="isWatched"/>
    <div class="relative flex items-center group">
        <div
            class="cursor-pointer relative"
            wire:click="toggleWatch"
            wire:loading.class="opacity-50"
        >
            <x-icon-eye-outline
                class="w-10 h-10 hover:text-primary-400 transition-colors {{ $isWatched ? 'fill-primary-500 text-zinc-900' : 'fill-none text-primary-500' }}"
            />

            @if($totalReviews > 0)
                <span
                    class="absolute bottom-0 right-0 -mb-1 -mr-1 bg-primary-800 text-white text-xs rounded-full
                    min-w-[1.25rem] h-5 px-1 flex items-center justify-center">
                    {{ $totalReviews }}
                </span>
            @endif

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
