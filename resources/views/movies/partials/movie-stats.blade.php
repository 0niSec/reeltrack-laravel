{{-- TODO: Implement conditional from watchedMovie --}}
<div class="mt-8 flex items-center gap-8" id="movie_stats">
    <div>
        <div class="text-3xl font-bold">{{ $movie->ratings?->avg() ?? "0" }}</div>
        <div class="text-sm text-primary-400">Average rating</div>
    </div>
    <div>
        <div class="text-3xl font-bold">{{ $movie->ratings?->count() ?? "0" }}</div>
        <div class="text-sm text-primary-400">Ratings</div>
    </div>
    <div>
        <div class="text-3xl font-bold">{{ $movie->likes?->count() ?? "0" }}</div>
        <div class="text-sm text-primary-400">Likes</div>
    </div>
</div>
