@php
    $createdAt = $review->created_at;
    $threshold = now()->subDays(); // Show exact date if older than 1 day
    $timeDisplay = $createdAt->greaterThanOrEqualTo($threshold)
        ? $createdAt->diffForHumans()
        : $createdAt->format('M d, Y');
@endphp

<div class="review-item flex flex-col h-full border-b border-primary-500/50 py-4 last:border-b-0">
    <div class="flex items-center space-x-3 mb-3" x-data="{ isOpen: false, showReply: false }">
        <div class="flex items-center space-x-3">
            @if($review->user->avatar)
                <img src="{{ $review->user->avatar }}" alt="{{ $review->user->username }}"
                     class="w-10 h-10 rounded-full">
            @else
                <img src="https://ui-avatars.com/api/?name={{ $review->user->username }}&background=random"
                     alt="Default avatar for {{ $review->user->username }}"
                     class="w-10 h-10 rounded-full">
            @endif

            <div>
                <a href="{{ route('profile', $review->user) }}"
                   class="hover:text-neutral-300">{{ $review->user->username }}</a>
                <div class="text-neutral-400 text-xs">
                    {{ $timeDisplay }}
                </div>
            </div>
        </div>
        <!-- Rating and Like Icons -->
        <div class="flex items-center">
            @if($review->reelEntry->rating !== null)
                <x-star-rating-display :rating="$review->reelEntry->rating" icon-size="w-5 h-5"
                                       icon-color="text-primary-400" icon-fill="fill-primary-400"/>
            @endif


            @if($review->reelEntry->is_liked)
                <x-icon-heart-filled class="w-5 h-5 ml-2 text-accent-500"/>
            @endif
        </div>
    </div>

    <!-- Review Content -->
    <div class="review-content text-sm leading-relaxed mb-8">
        @if(!Route::is('user.review'))
            {!! nl2br(e(Str::limit($review->content, 300, preserveWords: true))) !!}
        @else
            {!! nl2br(e($review->content)) !!}
        @endif
    </div>

    <!-- Actions Row -->
    <div class="mt-4 flex items-center space-x-10">
        <!-- Likes -->
        <div class="flex space-x-1 items-center">
            <!-- TODO: Apply middleware or Gate to make sure a user is logged in to like -->
            <x-icon-heart-outline
                class="w-6 h-6 text-neutral-500 cursor-pointer hover:fill-accent-500 hover:text-accent-500 transition-colors"/>
            <p class="text-sm">{{ Number::abbreviate($review->likes_count ?? 0) }} Likes</p>
        </div>

        <!-- Comments -->
        <div class="flex space-x-1 items-center">
            <x-icon-reply class="w-6 h-6 text-neutral-500 cursor-pointer"/>
            <p class="text-sm">
                <a href="{{ route('user.review', ['user' => $review->user, 'movie' => $movie, 'review' => $review]) }}">{{ Number::abbreviate($review->comments_count ?? 0) }}
                    Comments</a>
            </p>
        </div>

        <!-- Reply Button Container -->
        @if (Route::is('user.review'))
            <div id="reply-button-container" class="relative text-sm"
                 x-data="{ isOpen: false, showReply: false }">
                <button role="button"
                        class="px-4 py-2 w-fit bg-neutral-600 cursor-pointer border border-transparent hover:bg-neutral-700 hover:border-accent-500 transition-colors"
                        @click="isOpen = !isOpen">
                    ...
                </button>

                <!-- Reply Dropdown -->
                <div id="reply-dropdown"
                     class="font-semibold absolute top-full right-0 shadow-lg z-50"
                     @click="isOpen = ! isOpen"
                     x-show="isOpen"
                     @click.away="isOpen = false"
                     x-transition x-cloak>
                    <!-- Actions Outer Container -->
                    <div class="mt-2 bg-neutral-600 py-1 min-w-[160px]">
                        <!-- TODO: Reply should open either a component from the bottom (like Laracasts) or direct to the review page -->
                        <a href="#"
                           class="block px-2 py-1 hover:bg-neutral-700">Reply</a>
                        @auth
                            @if(auth()->id() === $review->user_id)
                                <a href="#"
                                   class="block px-2 py-1 hover:bg-neutral-700 transition-colors">Edit</a>

                                <button form="delete-form"
                                        wire:confirm.prompt="Are you sure you want to delete this review?"
                                        class="w-full text-left text-red-500 px-2 py-1 hover:bg-neutral-700 transition-colors">
                                    Delete
                                </button>
                            @else
                                <a href="#"
                                   class="block px-2 py-1 hover:bg-neutral-700">Report Spam</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @else
            <x-underlined-link
                href="{{ route('user.review', ['user' => $review->user, 'movie' => $movie, 'review' => $review]) }}">
                Read
                more
            </x-underlined-link>
        @endif
    </div>
    <form id="delete-form"
          action="{{ route('user.review.destroy', ['user' => $review->user, 'movie' => $movie, 'review' => $review]) }}"
          method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
