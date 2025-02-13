<div class="fixed inset-0 z-50 overflow-y-auto"
     x-show="showModal"
     x-cloak
     x-transition
     @movie-selected.window="showModal = false"
     @keydown.escape.window="showModal = false">
    {{-- Modal backdrop --}}
    <div class="fixed inset-0 bg-black opacity-75" @click="showModal = false"></div>

    {{-- Modal content --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-zinc-900 rounded-lg shadow-xl max-w-lg w-full p-6">
            <h2 class="text-xl font-thin mb-4">Pick a favorite movie</h2>
            <livewire:favorite-movie-search/>
            <button type="button" @click="showModal = false" class="absolute top-4 right-4">
                <x-icon-close class="w-6 h-6"/>
            </button>
        </div>
    </div>
</div>
