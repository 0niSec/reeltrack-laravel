<form class="relative" wire:submit.prevent="searchText">
    <div>
        <input
            type="text"
            placeholder="Search"
            class="w-full text-sm border border-zinc-700 rounded-lg px-2 py-1 text-zinc-200 bg-zinc-900
               focus:border-primary-500 focus:outline-none focus:ring-none focus:ring-primary-500"
            wire:model.live.debounce.300ms="searchText"
            wire:keydown.enter.prevent
        >

        @if(count($searchResults) > 0)
            <div class="absolute left-0 right-0 mt-1 bg-zinc-900 border border-zinc-700 rounded-lg
                        shadow-lg z-50 max-h-96 overflow-y-auto" id="search-results">
                @foreach($searchResults as $searchResult)
                    <a href="{{ route('movies.show', $searchResult) }}"
                       class="block px-4 py-2 hover:bg-zinc-800 border-zinc-800 text-zinc-200
                       text-sm"
                       wire:navigate.hover>
                        {{ $searchResult->title }} ({{ $searchResult->release_date->format('Y') }}) <span>{{
                        $searchResult->crew->where('job', 'Director')->first()->name
                        }}</span>
                    </a>
                @endforeach
            </div>
        @elseif($searchText && count($searchResults) === 0)
            <div class="absolute left-0 right-0 mt-1 bg-zinc-900 border border-zinc-700 rounded-lg
                        shadow-lg z-50 max-h-96 overflow-y-auto text-sm text-zinc-200" id="search-results">
                <span class="block px-4 py-2 bg-zinc-800">No results found matching query</span>

                <span class="inline-block px-4 py-2 text-xs text-zinc-400 font-thin">Need something added?</span>
                <a href="{{ route('about.creating-data') }}" class="hover:text-primary-400
                    hover:underline text-xs" wire:navigate>Find out how</a>
            </div>
        @endif
    </div>
</form>
