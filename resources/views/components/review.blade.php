{{-- review.blade.php --}}
<div class="review-item border-b border-gray-500/50 py-4 last:border-b-0">
    <div class="flex items-center space-x-3 mb-3">
        <div class="flex items-center space-x-3">
            @if($review->user->avatar)
                <img src="{{ $review->user->avatar }}" alt="{{ $review->user->username }}"
                     class="w-10 h-10 rounded-full">
            @else
                <img src="https://ui-avatars.com/api/?name={{ $review->user->username }}&background=random"
                     alt="Default avatar for {{ $review->user->username }}"
                     class="w-10 h-10 rounded-full">
            @endif

            <div class="font-medium text-primary-500">{{ $review->user->username }}</div>
            <div class="text-gray-500 text-sm">
                {{ $review->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="flex items-center">
            @php
                $rating = $review->rating;
                $fullStars = floor($rating);
                $hasHalfStar = ($rating - $fullStars) >= 0.5;
            @endphp

            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $fullStars)
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @elseif ($i == $fullStars + 1 && $hasHalfStar)
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <defs>
                            <linearGradient id="half-fill" x1="0" x2="100%" y1="0" y2="0">
                                <stop offset="50%" stop-color="currentColor"/>
                                <stop offset="50%" stop-color="#E5E7EB"/>
                            </linearGradient>
                        </defs>
                        <path fill="url(#half-fill)"
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endif
            @endfor
            @if($review->is_liked)
                <x-icon-heart-filled class="w-5 h-5 ml-2 text-primary-500"/>
            @endif
        </div>
    </div>

    <div class="review-content text-sm leading-relaxed">
        {{ $review->review_content }}
    </div>
</div>
