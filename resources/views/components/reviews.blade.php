<div>
    @if($reviews->isEmpty())
        <p>No reviews available.</p>
    @else
        @foreach($reviews as $review)
            <x-review :review="$review"/>
        @endforeach
    @endif
</div>
