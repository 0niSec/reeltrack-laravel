<div class="space-y-4">
    <h2 class="text-xl font-semibold">Reviews</h2>

    {{-- FIXME: Implement --}}
    @if (5 > 10)
        <div id="movie_reviews">
            <x-movie-review :movie="$movie" :reviews="$reviews"/>
        </div>
    @else
        <p class="text-primary-400">No reviews yet. Be the first to review this movie!</p>
        <p class="text-sm mt-8 text-primary-400">
            <a href="{{route('login')}}" class="text-primary-500 hover:underline">Sign in</a>
            to leave a review
        </p>
    @endif
</div>
