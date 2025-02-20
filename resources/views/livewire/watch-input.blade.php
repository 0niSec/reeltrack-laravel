<div
    x-data="{
        watched: $wire.entangle('isWatched'),
        loading: false,
        toggleWatch() {
            this.loading = true;
            $wire.toggleWatch().then(() => this.loading = false);
        }
    }"
    x-cloak
>
    <label class=" block text-sm text-primary-400 mb-1" x-text="watched ? 'Watched' : 'Watch'"></label>

    <div class="relative flex items-center group">
        <div class="cursor-pointer" x-on:click="toggleWatch">
            <template x-if="!loading">
                <x-icon-eye-outline
                    class="w-10 h-10 hover:text-primary-400 transition-colors"
                    x-bind:class="watched ? 'fill-primary-500 stroke-current text-zinc-900' :
                    'fill-none text-primary-500'"
                />
            </template>
            <template x-if="loading">
                <svg class="animate-spin w-10 h-10 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>

        </div>
    </div>
</div>
