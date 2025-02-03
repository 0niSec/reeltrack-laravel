<div>
    <label class="block text-sm text-primary-400 mb-1">{{ $liked ? 'Liked' : 'Like' }}</label>
    <div class="relative flex items-center group">
        <div class="cursor-pointer" wire:click.prevent="toggleLike">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-8 h-8 text-primary-600 hover:text-primary-400 hover:fill-primary-500 transition-colors' . {{
                $liked ? 'fill-primary-500' : 'fill-none'
                 }}"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"
                />
            </svg>
        </div>
    </div>
</div>
