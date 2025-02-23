@php
    use Carbon\Carbon;
@endphp

<x-app>
    <x-slot:title>
        {{ $movie->title }}
    </x-slot:title>

    {{-- Flash Message Container --}}
    @if(session('status'))
        <div class="absolute bg-green-600 rounded-md p-4 top-10 bottom-10 left-10 right-10">
            <div class="alert">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="absolute bg-red-600 rounded-md p-4 top-50 bottom-0 left-0 right-0 z-10">
            <div class="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Backdrop with gradient overlay --}}
    <div class="relative aspect-[2.76/1] w-full">
        <div class="absolute inset-0 bg-linear-to-t from-slate-950 "></div>
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
            <div class="w-[300px] shrink-0" x-data="{ isOpen: false }">
                <img
                    src="{{ $movie->poster_path }}"
                    alt="{{ $movie->poster_path }}"
                    class="w-full rounded-lg shadow-lg"
                />

                {{-- Action buttons --}}
                @auth
                    <div
                        class="mt-4 space-y-2"
                    >
                        
                        <button
                            type="button"
                            @click="isOpen = true"
                            class="w-full bg-zinc-800 text-primary-500 py-2 rounded-md hover:bg-zinc-700 transition-colors"
                        >
                            Leave a Reel or Review
                        </button>

                        {{-- Modal --}}
                        <x-review-modal :movie="$movie"/>
                    </div>
                @endauth
            </div>

            {{-- Right column: Movie details --}}
            <div class="grow ">
                {{-- Title and tagline --}}
                <h1 class="text-4xl text-primary-500 font-bold">{{ $movie->title }}</h1>
                @if (!empty($movie->tagline))
                    <p class="text-xl italic mt-2 text-primary-300">{{ $movie->tagline }}</p>
                @endif

                {{-- Meta information --}}
                <div class="flex items-center gap-4 mt-4">
                    <span class="text-zinc-400">{{ $movie->release_date->format('F d, Y') }}</span>
                    <span class="text-zinc-400">{{ $movie->runtime }} min</span>
                </div>

                {{-- Genres --}}
                @if (!empty($movie->genres))
                    <div class="flex gap-2 mt-4">
                        @foreach ($movie->genres as $genre)
                            <a
                                href="{{ route('movies.index', ['genre' => $genre->name ?? 'genre-placeholder']) }}"
                                class="px-3 py-1 font-medium rounded-full border border-primary-500 text-sm
                                hover:bg-primary-500 hover:text-white transition-colors"
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
                    <h2 class="text-primary-500 font-semibold mb-2">Overview</h2>
                    <p class="leading-relaxed">{{ $movie->overview }}</p>
                </div>

                {{-- User Actions Row --}}
                <!-- TODO: All of these components need to talk to each other in the modal -->
                @if (Auth::check())
                    <form>
                        @csrf
                        <div class="flex items-center space-x-10 my-4">
                            <!-- TODO: Make one parent component that holds all 3? -->
                            {{-- Watched Date --}}
                            <livewire:watch-input :movie-id="$movie->id"/>

                            {{-- Rating Input --}}
                            <livewire:rating-input :movie-id="$movie->id"/>

                            {{-- Like Input --}}
                            <livewire:like-input :movie-id="$movie->id"/>

                            {{-- Watchlist --}}
                            {{-- Kebab case for the prop is okay --}}
                            <livewire:watchlist-input :movie-id="$movie->id"/>
                        </div>
                    </form>
                @else
                    <!-- TODO: Find a way to redirect back here -->
                    <div class="my-6"><a href="{{ route('login') }}"
                                         class="p-2 rounded-md bg-primary-700 text-zinc-200 shadow-md
                                         inset-shadow-sm hover:bg-primary-800 transition-all ">Login
                            to rate or review</a></div>
                @endauth


                {{-- Cast & Crew Tabs --}}
                <x-cast-crew-tabs :cast="$movie->cast" :crew="$movie->crew"/>

                <a href="{{ route('movies.cast-and-crew', $movie) }}" class="block mt-4
                text-primary-500 font-medium
                hover:text-primary-600
                hover:underline
                transition-all underline-offset-2">Full
                    Cast & Crew</a>

                {{-- Reviews --}}
                {{--                <div class="mt-8" id="movie_reviews">--}}
                {{--                    <x-movie-reviews :movie="$movie"/>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
</x-app>
