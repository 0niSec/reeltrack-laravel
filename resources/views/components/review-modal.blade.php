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
                        Review {{ $movie->title }}
                    </h2>
                    <button
                        type="button"
                        @click="isOpen = false;confirm('Are you sure you want to cancel?')"
                        class="text-zinc-400 hover:text-primary-500"
                    >
                        <!-- Close Icon -->
                        <x-icon-close class="w-6 h-6"/>
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
                            {{-- Rating Input --}}
                            {{-- TODO: Add --}}
                        </div>

                        {{-- Like --}}
                        <div class="flex-1">
                            {{-- TODO: Add --}}
                        </div>
                    </div>

                    {{-- Watch --}}
                    {{-- TODO: Add --}}

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
