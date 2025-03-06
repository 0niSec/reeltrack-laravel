{{-- reviews.blade.php - This is the container for all reviews --}}
<div>
    @if($reviews->isEmpty())
        <p class="text-gray-500">No reviews yet! Be the first to <a href="#"
                                                                    @click.prevent="$dispatch('open-review-modal')"
                                                                    class="text-primary-500 hover:text-primary-600">
                write a review
            </a>.
        </p>
    @else
        <div class="space-y-4"> {{-- Add spacing between reviews --}}
            @foreach ($reviews as $review)
                <x-review :review="$review" :movie="$movie"/>
            @endforeach
        </div>
    @endif
</div>
