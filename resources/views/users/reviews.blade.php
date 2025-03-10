<x-app>
    <x-slot:title>{{  $user->username }}'s {{ $movie->title }} Reviews</x-slot:title>


    <div class="container max-w-6xl mt-10">
        <h1 class="text-2xl font-bold mb-6">{{ $movie->title }} Reviews</h1>

        @if ($reviews->isEmpty())
            <p class="text-gray-600">No reviews available for this movie.</p>
        @else
            <div class="space-y-4">
                @foreach ($reviews as $review)
                    <div class="border border-gray-300 rounded-lg p-4">
                        <h2 class="text-lg font-semibold">{{ $user->username }}</h2>
                        <p class="text-gray-700 mt-2">{{ $review->content }}</p>
                        <p class="text-sm text-gray-500 mt-2">Reviewed
                            on {{ $review->created_at->format('F j, Y') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app>
