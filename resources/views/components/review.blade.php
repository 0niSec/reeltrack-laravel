@php
    $createdAt = $review->created_at;
    $threshold = now()->subDays();
    $timeDisplay = $createdAt->greaterThanOrEqualTo($threshold)
        ? $createdAt->diffForHumans()
        : $createdAt->format('M d, Y');
@endphp

@props([
    'review',
    'movie'
])

<div
    class="{{ request()->routeIs('reviews.show') ? 'bg-surface p-8 mt-8 shadow-md' : 'review-item flex flex-col h-full ' }}">
    <!-- Main Content Area -->
    <div class="flex items-start space-x-3">
        <!-- Avatar Column -->
        <div class="flex-shrink-0">
            @if($review->user->avatar)
                <img src="{{ $review->user->avatar }}"
                     alt="{{ $review->user->username }}"
                     class="w-10 h-10 rounded-full">
            @else
                <img src="https://ui-avatars.com/api/?name={{ $review->user->username }}&background=random"
                     alt="Default avatar for {{ $review->user->username }}"
                     class="w-10 h-10 rounded-full">
            @endif
        </div>

        <!-- Content Column -->
        <div class="flex-grow">
            <!-- User Info and Ratings Row -->
            <div class="flex items-center justify-between mb-2">
                <div>
                    <a href="{{ route('users.profile', $review->user) }}"
                       class="hover:text-neutral-300">{{ $review->user->username }}</a>
                    @if(Route::is('reviews.show'))
                        <x-original-poster-box class="ml-1"/>
                    @endif
                    <div class="text-neutral-400 text-xs">
                        {{ $timeDisplay }}
                    </div>
                </div>

                <!-- Rating and Like Icons -->
                <div class="flex items-center">
                    @if($review->reelEntry->rating !== null)
                        <x-star-rating-display :rating="$review->reelEntry->rating"
                                               icon-size="w-5 h-5"
                                               icon-color="text-primary-400"
                                               icon-fill="fill-primary-400"/>
                    @endif

                    @if($review->reelEntry->is_liked)
                        <x-icon-heart-filled class="w-5 h-5 ml-2 text-accent-500"/>
                    @endif
                </div>
            </div>

            <!-- Review Content -->
            <div class="review-content text-sm leading-relaxed mb-8">
                @if(!Route::is('reviews.show'))
                    {!! nl2br(e(Str::limit($review->content, 300, preserveWords: true))) !!}
                @else
                    {!! nl2br(e($review->content)) !!}
                @endif
            </div>

            <!-- Actions Row -->
            <div class="mt-4 flex items-center justify-between space-x-10">
                <!-- Likes -->
                <div class="flex flex-row space-x-4">
                    <div class="flex space-x-1 items-center">
                        <x-icon-heart-outline
                            class="w-6 h-6 text-neutral-500 cursor-pointer hover:fill-accent-500 hover:text-accent-500 transition-colors"/>
                        <p class="text-sm">{{ Number::abbreviate($review->likes_count ?? 0) }} Likes</p>
                    </div>

                    <!-- Comments -->
                    <div class="flex space-x-1 items-center">
                        <x-icon-reply class="w-6 h-6 text-neutral-500 cursor-pointer"/>
                        <p class="text-sm">
                            <a href="{{ route('reviews.show', ['user' => $review->user, 'movie' => $movie, 'review' => $review]) }}">
                                {{ Number::abbreviate($review->comments_count ?? 0) }} Comments
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if (Route::is('reviews.show') && !auth()->guest())
                    <x-comment-action-button :review="$review" :user="$review->user" :movie="$movie"/>
                @elseif(Route::is('movies.show') || Route::is('reviews.index'))
                    <x-underlined-link
                        href="{{ route('reviews.show', ['user' => $review->user, 'movie' => $movie, 'review' => $review]) }}">
                        Read more
                    </x-underlined-link>
                @endif
            </div>
        </div>
    </div>
</div>
