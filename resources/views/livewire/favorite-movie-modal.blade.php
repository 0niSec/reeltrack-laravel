<div class="fixed inset-0 z-50 overflow-y-auto"
     x-show="$wire.isOpen"
     x-cloak
     x-transition
     wire:ignore
     @keydown.escape.window="$wire.close">
    {{-- Modal backdrop --}}
    <div class="fixed inset-0 bg-black opacity-75" wire:click="closeModal"></div>

    {{-- Modal content --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-zinc-900 rounded-lg shadow-xl max-w-lg w-full p-6">
            <h2 class="text-xl font-thin mb-4">Pick a favorite movie</h2>
            <livewire:favorite-movie-search/>
            <button type="button" wire:click="closeModal" class="absolute top-4 right-4">
                <x-icon-close class="w-6 h-6"/>
            </button>
        </div>
    </div>
</div>
