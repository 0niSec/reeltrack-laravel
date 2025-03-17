@php
    use Carbon\Carbon;
//    $currentUserReview = auth()->user()?->getCurrentReviewFor($movie);
@endphp

<x-app>
    <x-slot:title>
        {{ $movie->title }}
    </x-slot:title>

    {{-- Backdrop with gradient overlay --}}
    <div class="relative aspect-[3/1] w-full">
        <div class="absolute inset-0 bg-linear-to-t from-background to-background/50"></div>
        <img
            src="{{ $movie->backdrop_path }}"
            alt="{{ $movie->title }}"
            class="w-full h-full object-cover object-center"
        />
    </div>

    {{-- Main content --}}
    <div class="container max-w-6xl mx-auto -mt-80 relative z-10">
        <div class="flex gap-8">
            {{-- Left column: Poster and actions --}}
            <div class="w-[250px] shrink-0">
                <img
                    src="{{ $movie->poster_path }}"
                    alt="{{ $movie->poster_path }}"
                    class="w-full rounded-lg shadow-lg"
                />

                {{-- Action buttons --}}
                @auth
                    <div
                        class="mt-4 space-y-1"
                    >
                        {{-- Modal & Action Buttons --}}
                        <livewire:review-modal :movie="$movie"/>
                        <x-share-button/>
                    </div>
                @endauth
            </div>

            {{-- Right column: Movie details --}}
            <div class="grow">
                {{-- Title and tagline --}}
                <h1 class="text-4xl text-primary-500 font-bold">{{ $movie->title }}</h1>
                @if (!empty($movie->tagline))
                    <p class="text-xl italic mt-2 text-primary-300">{{ $movie->tagline }}</p>
                @endif

                {{-- Meta information --}}
                <div class="flex items-center gap-4 mt-4">
                    <span class="text-gray-400">{{ $movie->release_date->format('F d, Y') }}</span>
                    <span class="text-gray-400">{{ $movie->runtime }} min</span>
                </div>

                {{-- Genres --}}
                @if (!empty($movie->genres))
                    <div class="flex gap-2 mt-4">
                        @foreach ($movie->genres as $genre)
                            <x-genre-pill-link :genre="$genre"/>
                        @endforeach
                    </div>
                @endif

                {{-- Movie Stats --}}
                <x-movie-stats :movie="$movie"/>
                
                {{-- Overview --}}
                <div class="mt-8">
                    <h2 class="text-primary-400 font-semibold mb-2">Overview</h2>
                    <p class="leading-relaxed">{{ $movie->overview }}</p>
                </div>

                {{-- User Actions Row --}}
                @if (Auth::check())
                    <form>
                        @csrf
                        <div class="flex items-center space-x-10 my-4">
                            {{-- Watched Date --}}
                            <livewire:watch-input :movie="$movie"/>

                            {{-- Rating Input --}}
                            <livewire:rating-input :movie="$movie"/>

                            {{-- Like Input --}}
                            <livewire:like-input :movie="$movie"/>

                            {{-- Watchlist --}}
                            {{-- Kebab case for the prop is okay --}}
                            <livewire:watchlist-input :movie="$movie"/>
                        </div>
                    </form>
                @else
                    <!-- TODO: Find a way to redirect back here -->
                    <div class="my-6"><a href="{{ route('login') }}"
                                         class="p-2 rounded-md bg-primary-700 text-gray-200 shadow-md
                                         inset-shadow-sm hover:bg-primary-800 transition-all ">Login
                                                                                               to rate or review</a>
                    </div>
                @endauth


                {{-- Cast & Crew Tabs --}}
                <x-cast-crew-tabs :cast="$movie->cast" :crew="$movie->crew"/>

                <x-underlined-link href="{{ route('movies.cast-and-crew', $movie) }}" :movie="$movie"
                                   class="block font-medium mt-4">Full Cast & Crew
                </x-underlined-link>

                {{-- Reviews --}}
                <h2 class="mt-10">Reviews</h2>
                <div class="mt-8" id="movie_reviews">
                    <x-reviews :reviews="$reviews" :movie="$movie"/>
                </div>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</x-app>
