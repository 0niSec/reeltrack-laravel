@props(['comment'])

@php
    $createdAt = $comment->created_at;
    $threshold = now()->subDays();
    $timeDisplay = $createdAt->greaterThanOrEqualTo($threshold)
        ? $createdAt->diffForHumans()
        : $createdAt->format('M d, Y');
    $isOP = $comment->user->id === $comment->review->user->id;
@endphp

<div class="flex flex-col mb-6 bg-surface shadow-md p-8 {{ $loop->parent->first ?? 'ml-10' }}">
    <!-- User Info and Content -->
    <div class="flex items-start space-x-3 mb-3">
        <!-- Avatar -->
        <div class="flex-shrink-0">
            @if($comment->user->avatar)
                <img src="{{ $comment->user->avatar }}"
                     alt="{{ $comment->user->username }}"
                     class="w-10 h-10 rounded-full">
            @else
                <img src="https://ui-avatars.com/api/?name={{ $comment->user->username }}&background=random"
                     alt="Default avatar for {{ $comment->user->username }}"
                     class="w-10 h-10 rounded-full">
            @endif
        </div>

        <!-- Comment Content Container -->
        <div class="flex-grow">
            <!-- User Info -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('users.profile', $comment->user) }}"
                   class="hover:text-neutral-300">{{ $comment->user->username }}</a>
                @if(Route::is('reviews.show') && $isOP)
                    <x-original-poster-box/>
                @endif
            </div>

            <div class="text-neutral-400 text-xs mb-2">
                {{ $timeDisplay }}
            </div>

            <!-- Comment Content -->
            <div class="text-sm leading-relaxed">
                {!! nl2br(e($comment->content)) !!}
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @auth
        <div class="ml-13 flex justify-between items-center mt-4">
            <div class="flex space-x-4 text-sm">
                <button
                    class="bg-primary-600 hover:bg-primary-800 transition-colors shadow-sm px-8 py-1.5 font-medium inline-flex items-center space-x-2">
                    <x-icon-heart-outline class="w-6 h-6"/>
                    <span class="">0</span>
                </button>
                <button class="bg-primary-600 hover:bg-primary-800 transition-colors shadow-sm px-8 py-1.5 font-medium">
                    Reply
                </button>
            </div>
            @if(request()->routeIs('reviews.show'))
                <x-comment-action-button :comment="$comment"/>
            @endif
        </div>
    @endauth

</div>
