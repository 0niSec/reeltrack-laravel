@props([
    /** @var \App\Models\Movie */
    'movie'
])

<div {{ $attributes->class(['mt-8 flex items-center gap-8']) }} id="movie_stats">
    <div>
        <div class="text-3xl font-bold">{{ Number::abbreviate($movie->avg_rating, 2) ?? "0" }}</div>
        <div class="text-sm text-primary-400">Average rating</div>
    </div>
    <div>
        <div class="text-3xl font-bold">{{ Number::abbreviate($movie->ratings_count) ?? "0" }}</div>
        <div class="text-sm text-primary-400">Ratings</div>
    </div>
    <div>
        <div class="text-3xl font-bold">{{ Number::abbreviate($movie->likes_count) ?? "0" }}</div>
        <div class="text-sm text-primary-400">Likes</div>
    </div>
</div>
