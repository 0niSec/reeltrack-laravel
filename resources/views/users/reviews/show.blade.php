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
            @foreach ($review->comments as $comment)
                <div class="space-y-4">
                    <x-comment :comment="$comment" :movie="$movie" :user="$user"/>

                    {{-- Replies --}}
                    @if($comment->replies->count() > 0)
                        <div class="ml-8 space-y-4 border-l-2 border-neutral-700 pl-4">
                            @foreach($comment->replies as $reply)
                                <x-comment :comment="$reply" :movie="$movie" :user="$user"/>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app>
