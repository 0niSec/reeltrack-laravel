<div
    class="movie-card text-center w-full rounded-lg relative group border-2 border-transparent hover:border-primary-500 transition-all duration-300 cursor-pointer"
>
    @if ($movie['poster_path'])
        <img
            src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
            alt="Movie Poster"
            class="w-full rounded-lg transition-colors duration-300"
        />

        {{-- Overlay --}}
        <div
            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100
                   transition-opacity duration-300 rounded-lg flex items-center justify-center"
        >
            @include('movies.partials.movie_actions')
        </div>
    @endif
</div>
