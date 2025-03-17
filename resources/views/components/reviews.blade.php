{{-- reviews.blade.php - This is the container for all reviews --}}
<div>
    @if($reviews->isEmpty())
        <p class="text-gray-500">No reviews yet! Be the first to
            <x-underlined-link class="cursor-pointer" @click="$wire.showModal"> {{-- TODO: This doesn't open the
            modal --}}
                write a review
            </x-underlined-link>
                                 .
        </p>
    @else
        <div class="space-y-4"> {{-- Add spacing between reviews --}}
            @foreach ($reviews as $review)
                <x-review :review="$review" :movie="$movie"/>
            @endforeach
        </div>
    @endif
</div>
