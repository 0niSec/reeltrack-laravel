{{--@php--}}
{{--    dd($review);--}}
{{--@endphp--}}

<x-app>
    <x-slot:title>{{  $user->username }}'s {{ $movie->title }} Review</x-slot:title>


    <div class="container max-w-6xl mt-10">
        @if(auth()->user() === $user)
            <span
                class="font-extralight text-sm text-neutral-400 block leading-2">{{ $user->username }}'s review for</span>
        @else
            <span
                class="font-extralight text-sm text-neutral-400 block leading-2">Your review for</span>
        @endif
        <h1 class="text-2xl font-bold">{{ $movie->title }}</h1>
        <p class="text-neutral-400 text-xs">Watched on {{ $review->reelEntry->watched_at->toFormattedDateString() }}</p>

        <div class="space-y-4">
            <x-review :review="$review" :movie="$movie"/>
        </div>
    </div>
</x-app>
