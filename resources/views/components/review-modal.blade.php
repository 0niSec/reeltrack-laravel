<div>
    <!-- Modal backdrop -->
    <div
        class="fixed inset-0 bg-zinc-800/50 backdrop-blur-lg  z-50"
        x-show="isOpen"
        x-cloak
        x-transition
        @click="isOpen = false"
        @keydown.escape.window="isOpen = false"
        style="display: none;" {{-- Ensures Alpine begins with display: none --}}
    >
        <!-- Modal inner container -->
        <div
            class="fixed inset-0 flex items-center justify-center p-4"
            @click.stop {{-- Prevent clicks inside from closing the modal --}}
        >
            {{-- Modal content --}}
            <div class="bg-zinc-900 rounded-lg shadow-xl max-w-2xl w-full p-6">
                {{-- Modal Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-primary-500">
                        Review {{ $movie['title'] }}
                    </h2>
                    <button
                        type="button"
                        @click="isOpen = false"
                        class="text-zinc-400 hover:text-primary-500"
                    >
                        <!-- Close Icon -->
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
                    action="{{ route('movies.reel.store', ['movie' => $movie->id]) }}"
                    method="POST"
                    class="space-y-6"
                >
                    @csrf

                    {{-- Rating and Like Row --}}
                    <div class="flex items-center gap-8">
                        {{-- Rating --}}
                        <div class="flex-1">
                            {{-- Rating Input Partial (placeholder usage) --}}
                            <livewire:rating-input :movie="$movie"/>
                        </div>

                        {{-- Like (placeholder to implement) --}}
                        <div class="flex-1">
                            <livewire:like-input :movie="$movie"/>
                        </div>
                    </div>

                    {{-- Watch Date --}}
                    <livewire:watch-input :movie="$movie"/>

                    {{-- Review Text --}}
                    <div>
                        <label class="block text-sm text-primary-400 mb-1">Your Review</label>
                        <textarea
                            name="content"
                            rows="4"
                            placeholder="Share your thoughts about the movie..."
                            class="w-full bg-zinc-800 text-primary-400 border border-zinc-700 rounded-md px-3 py-2
                            placeholder:text-zinc-500 focus:ring-primary-500 focus:border-primary-500"
                        >{{ old('content') }}</textarea>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
