@php
    use Carbon\Carbon;
@endphp

<x-app>
    <x-slot:title>
        {{ $movie->title }} - ReelTrack
    </x-slot:title>
    {{-- Backdrop with gradient overlay --}}
    <div class="relative aspect-[2.76/1] w-full">
        <div class="absolute inset-0 bg-linear-to-t from-neutral-900 to-transparent"></div>
        <img
            src="{{ $movie->backdrop_path }}"
            alt="{{ $movie->title }}"
            class="w-full h-full object-cover object-center"
        />
    </div>

    {{-- Main content --}}
    <div class="container max-w-6xl mx-auto -mt-64 relative z-10">
        <div class="flex gap-8">
            {{-- Left column: Poster and actions --}}
            <div class="w-[300px] shrink-0">
                <img
                    src="{{ $movie->poster_path }}"
                    alt="{{ $movie->poster_path }}"
                    class="w-full rounded-lg shadow-lg"
                />

                {{-- Action buttons --}}
                <div
                    class="mt-4 space-y-2"
                    data-controller="modal"
                    data-modal-debug-value="true"
                >
                    <button
                        type="button"
                        class="w-full bg-primary-500 text-neutral-800 py-2 rounded-md hover:bg-primary-600 transition-colors"
                    >
                        Add to Watchlist
                    </button>

                    <button
                        type="button"
                        data-action="modal#open"
                        class="w-full bg-neutral-800 text-primary-500 py-2 rounded-md hover:bg-neutral-700 transition-colors"
                    >
                        Review Movie
                    </button>

                    {{-- Modal --}}
                    <div data-modal-target="container">
                        <!-- TODO: Implement review modal -->
                    </div>
                </div>
            </div>

            {{-- Right column: Movie details --}}
            <div class="grow text-primary-500">
                {{-- Title and tagline --}}
                <h1 class="text-4xl font-bold">{{ $movie->title }}</h1>
                @if (!empty($movie->tagline))
                    <p class="text-xl italic mt-2 text-primary-400">{{ $movie->tagline }}</p>
                @endif

                {{-- Meta information --}}
                <div class="flex items-center gap-4 mt-4">
                    <span>{{ $movie->release_date->format('F d, Y') }}</span>
                    <span>{{ $movie->runtime }} min</span>
                </div>

                {{-- Genres --}}
                @if (!empty($movie->genres))
                    <div class="flex gap-2 mt-4">
                        @foreach ($movie->genres as $genre)
                            <a
                                href="{{ route('movies.index', ['genre' => $genre->name ?? 'genre-placeholder']) }}"
                                class="px-3 py-1 rounded-full border border-primary-500 text-sm hover:bg-primary-500 hover:text-white transition-colors"
                            >
                                {{ $genre->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Movie Stats --}}
                @include('movies.partials.movie-stats', ['movie' => $movie])

                {{-- Overview --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-2">Overview</h2>
                    <p class="text-primary-400 leading-relaxed">{{ $movie->overview }}</p>
                </div>

                {{-- User Actions Row --}}
                <form
                    action="#"
                    method="POST"
                    class="mb-8"
                >
                    @csrf
                    <div class="flex items-center gap-8 mt-6">
                        {{-- Watched Date --}}
                        <div>
                            <label class="block text-sm text-primary-400 mb-1">Watched</label>
                            <input
                                type="date"
                                name="watched_date"
                                value="{{ now()->format('Y-m-d') }}"
                                class="bg-neutral-800 text-primary-400 border border-neutral-700 rounded-md px-3 py-1.5 focus:ring-primary-500 focus:border-primary-500"
                            />
                        </div>

                        {{-- Rating Input Partial (placeholder usage) --}}
                        <x-rating-input/>

                        {{-- Like Input Partial (placeholder usage) --}}
                        <x-like-input/>
                    </div>
                </form>

                {{-- Cast & Crew Tabs --}}
                <x-cast-crew-tabs :cast="$movie->cast" :crew="$movie->crew"/>

                {{-- Reviews --}}
                {{--                <div class="mt-8" id="movie_reviews">--}}
                {{--                    <x-movie-reviews :movie="$movie"/>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
</x-app>
