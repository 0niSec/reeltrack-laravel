<x-app>
    <x-slot:title>{{  $user->username }}'s {{ $movie->title }} Reviews</x-slot:title>


    <div class="container max-w-6xl mt-10">
        @if(auth()->user() === $user)
            <span
                class="font-extralight text-sm text-neutral-400 block leading-2">{{ $user->username }}'s reviews for</span>
        @else
            <span
                class="font-extralight text-sm text-neutral-400 block leading-2">Your reviews for</span>
        @endif
        <h1 class="text-2xl font-bold mb-6">{{ $movie->title }}</h1>

        @if ($reviews->isEmpty())
            <p class="text-neutral-500">No reviews available for this movie.</p>
        @else
            <div class="space-y-4">
                @foreach ($reviews as $review)
                    <x-review :review="$review" :movie="$movie"/>
                @endforeach
            </div>
        @endif
    </div>
</x-app>
