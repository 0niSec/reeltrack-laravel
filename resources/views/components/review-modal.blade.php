<div
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50"
    data-action="keydown.escape->modal#close"
>
    <div
        class="fixed inset-0 flex items-center justify-center p-4"
        data-action="click->modal#closeBackground"
    >
        <div class="bg-neutral-900 rounded-lg shadow-xl max-w-2xl w-full p-6">
            {{-- Modal Header --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-primary-500">
                    Review {{ $movie['title'] }}
                </h2>
                <button
                    type="button"
                    data-action="modal#close"
                    class="text-neutral-400 hover:text-primary-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            {{-- Begin form --}}
            <form
                action="{{ route('movie_reviews.store', ['movie_id' => $movie->tmdb_id]) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf

                {{-- Rating and Like Row --}}
                <div class="flex items-center gap-8">
                    {{-- Rating --}}
                    <div class="flex-1">
                        @include('shared.rating_input', [
                            'form'           => null,
                            'initial_rating' => optional($watched_movie)->rating
                        ])
                    </div>

                    {{-- Like (placeholder to implement) --}}
                    <div class="flex-1">
                        <!-- TODO: Implement -->
                        @include('shared.like_input', [
                            'initial_liked' => optional($watched_movie)->liked
                        ])
                    </div>
                </div>

                {{-- Watch Date --}}
                <div>
                    <label class="block text-sm text-primary-400 mb-1">
                        {{ $watched_movie && $watched_movie->watched_date ? 'Watched' : 'Watched on' }}
                    </label>
                    <input
                        type="date"
                        name="watched_date"
                        value="{{ old('watched_date', optional($watched_movie)->watched_date ? optional($watched_movie->watched_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        class="w-full bg-neutral-800 text-primary-400 border border-neutral-700 rounded-md px-3 py-1.5 focus:ring-primary-500 focus:border-primary-500"
                    />
                </div>

                {{-- Review Text --}}
                <div>
                    <label class="block text-sm text-primary-400 mb-1">Your Review</label>
                    <textarea
                        name="content"
                        rows="4"
                        placeholder="Share your thoughts about the movie..."
                        class="w-full bg-neutral-800 text-primary-400 border border-neutral-700 rounded-md px-3 py-2 placeholder:text-neutral-500 focus:ring-primary-500 focus:border-primary-500"
                    >{{ old('content') }}</textarea>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors cursor-pointer"
                    >
                        Post Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
