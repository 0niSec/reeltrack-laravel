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
            <div class="bg-gray-950 rounded-lg shadow-xl max-w-3xl w-full relative">
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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600 text-xs mt-2">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- Watch --}}
                    <x-watch-date :movie="$movie"/>

                    {{-- Review Text --}}
                    <div>
                        <x-form-label for="review_content" value="Review">Review</x-form-label>
                        <x-form-textarea name="review_content" rows="10" class="w-full"/>
                        <x-form-error name="review_content"/>

                        <div class="w-full rounded-md mt-2">
                            <label class="flex items-center text-sm gap-2">
                                <div class="relative flex items-center">
                                    <input type="checkbox"
                                           name="contains_spoilers"
                                           :checked="{{old('contains_spoilers')}}"
                                           class="peer appearance-none w-5 h-5 rounded border-2 border-gray-600
              checked:bg-primary-500 checked:border-primary-500
              hover:border-primary-400 focus:ring-2 focus:ring-primary-500/20
              bg-gray-700 transition-all duration-200 ease-in-out cursor-pointer"
                                           id="contains-spoilers"/>

                                    <svg
                                        class="absolute w-5 h-5 pointer-events-none text-white peer-checked:block hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span>Contains spoilers</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Rating and Like Row --}}
                    <div class="flex items-center w-full justify-end space-x-10">
                        <livewire:rating-input-modal :movie="$movie"/>
                        <livewire:like-input-modal :movie="$movie"/>
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
