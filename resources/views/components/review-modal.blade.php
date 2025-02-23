<div>
    <!-- Modal backdrop -->
    <div
        class="fixed inset-0 bg-gray-800/30 backdrop-blur-lg  z-50"
        x-show="isOpen"
        x-cloak
        x-transition
        @click="isOpen = false"
        @keydown.escape.window="isOpen = false"
        style="display: none;" {{-- Ensures Alpine begins with display: none --}}
    >
        <!-- Modal inner container -->
        <div
            class="fixed inset-0 flex items-center justify-center p-6"
            @click.stop {{-- Prevent clicks inside from closing the modal --}}
        >
            {{-- Modal content --}}
            <div class="bg-gray-900 rounded-lg shadow-xl max-w-3xl w-full relative">
                {{-- Modal Header --}}
                <div class="px-10 pt-10">
                    <div class="flex justify-between items-center border-b pb-4 mb-4 border-gray-500">
                        <h2 class="text-xl font-semibold text-primary-500">
                            Review {{ $movie->title }}
                        </h2>
                        <button
                            type="button"
                            @click="isOpen = false;confirm('Are you sure you want to cancel?')"
                            class="text-gray-400 hover:text-primary-500 absolute top-8 right-8"
                        >
                            <x-icon-close class="w-6 h-6"/>
                        </button>
                    </div>
                </div>

                {{-- Begin form --}}
                <form
                    action="{{ route('movies.reel.store', $movie) }}"
                    method="POST"
                    class="px-10 space-y-6"
                >
                    @csrf

                    {{-- Watch --}}
                    <livewire:watched-date/>

                    {{-- Review Text --}}
                    <div>
                        <x-form-label for="review" value="Review">Review</x-form-label>
                        <x-form-textarea name="review" rows="5" class="w-full"/>
                    </div>

                    {{-- Rating and Like Row --}}
                    <div class="flex items-center w-full justify-end space-x-10">
                        <livewire:rating-input-modal :movie-id="$movie->id"/>
                        <livewire:like-input-modal :movie-id="$movie->id"/>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end p-4 mt-6 border-t border-gray-500">
                        <x-form-submit-button>Save</x-form-submit-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
