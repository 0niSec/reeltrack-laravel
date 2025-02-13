<div class="p-10 bg-zinc-800 rounded-sm shadow-lg border border-zinc-700 cursor-pointer group flex
        justify-center items-center min-h-40"
     x-data="{ showModal: false }"
     @click="showModal = true">

    @if(!$selectedMovie)
        <x-icon-add class="w-8 h-8 stroke-zinc-700 stroke-2
                drop-shadow-md
                group-hover:stroke-zinc-300
                transition-all ease-in-out
                cursor-pointer"/>
    @else
        <img src="{{ $selectedMovie['poster_path'] }}"
             alt="{{ $selectedMovie['title'] }}"
             class="w-full h-full object-cover">
    @endif

    <template x-teleport="body">
        <livewire:favorite-movie-modal x-show="showModal" @close="showModal = false"/>
    </template>
</div>
