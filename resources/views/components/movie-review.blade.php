@php use Carbon\Carbon; @endphp
<div class="review mt-4" id="review_{{ $review->id }}">
    <div class="flex items-center">
        <div class="w-10 h-10 rounded-full bg-neutral-800 flex items-center justify-center text-primary-500">
            {{ strtoupper(mb_substr($review->user->username, 0, 1)) }}
        </div>
        <div class="ml-3">
            <div class="text-sm font-semibold text-primary-500">
                Review by {{ $review->user->username }}
            </div>
            <div class="flex items-center gap-2">
                @if(!empty($review->watched_movie->rating))
                    <div class="text-primary-400">
                        @php
                            $rating = $review->watched_movie->rating;
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5;
                        @endphp

                        {{-- Full stars --}}
                        @for($i = 0; $i < $fullStars; $i++)
                            ★
                        @endfor

                        {{-- Half star if needed --}}
                        @if($halfStar)
                            ½
                        @endif

                        <span class="text-neutral-600">
                            {{-- Remaining stars --}}
                            @for($j = 0; $j < (5 - $fullStars - ($halfStar ? 1 : 0)); $j++)
                                ★
                            @endfor
                        </span>
                    </div>
                @endif

                @if(!empty($review->watched_movie->liked) && $review->watched_movie->liked)
                    <div class="text-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="currentColor"
                             class="w-4 h-4"
                        >
                            <path
                                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                        </svg>
                    </div>
                @endif

                @if(!empty($review->watched_movie->watched_date))
                    <div class="text-xs text-gray-400">
                        {{ Carbon::parse($review->watched_movie->watched_date)->format('F d, Y') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <p class="mt-2 text-primary-400">
        {{ $review->content }}
    </p>
</div>
