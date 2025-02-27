{{-- reviews.blade.php - This is the container for all reviews --}}
<div>
    @if($reviews->isEmpty())
        <p class="text-gray-500">No reviews available.</p>
    @else
        <div class="space-y-4"> {{-- Add spacing between reviews --}}
            @foreach ($reviews as $review)
                <x-review :review="$review" :movie="$movie"/>
            @endforeach
        </div>
    @endif
</div>
