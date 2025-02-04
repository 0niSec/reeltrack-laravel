@php
    // Replace the spaces in the title with \n as placehold.co wants
    $formattedTitle = urlencode(str_replace(' ', '\n', $movie->title));
@endphp

<div
    class="movie-card text-center w-full rounded-lg relative group border-2 border-transparent hover:border-primary-500 transition-all duration-300 cursor-pointer"
>
    @if ($movie->poster_path)
        <img
            src="{{$movie->poster_path}}"
            alt="Movie Poster"
            class="w-full rounded-lg transition-colors duration-300"
        />

        {{-- Overlay --}}
        <div
            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100
                   transition-opacity duration-300 rounded-lg flex items-center justify-center"
        >
            @auth
                @include('movies.partials.movie_actions')
            @endauth
        </div>

    @else
        <div class="aspect-2/3 overflow-hidden rounded-lg">
            <img
                src="{{'https://placehold.co/800x1280?text=' . $formattedTitle . '&font=Poppins'}}"
                alt="Movie Poster"
                class="w-full object-contain object-center transition-colors duration-300"
            />
        </div>

        {{-- Overlay --}}
        <div
            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100
               transition-opacity duration-300 rounded-lg flex items-center justify-center"
        >
            @auth
                @include('movies.partials.movie_actions')
            @endauth
        </div>
    @endif
</div>
