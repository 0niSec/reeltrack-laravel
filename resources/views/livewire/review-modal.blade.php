@php
    $currentUserReview = auth()->user()?->getCurrentReviewFor($movie);
@endphp
<div>
    <div class="flex flex-col mt-2 space-y-1">
        <x-open-modal-button>Reel or Review</x-open-modal-button>
        @if($currentUserReview)
            <x-open-modal-button>Edit your Reel or Review...</x-open-modal-button>
        @endif
    </div>
    <!-- Modal backdrop -->
    <div
        class="fixed inset-0 bg-background/30 backdrop-blur-lg z-50"
        x-on:click="$wire.showModal = false"
        wire:cloak
        wire:transition
        wire:show="showModal"
        @keydown.escape.window="$wire.showModal = false"
    >
        <!-- Modal inner container -->
        <div
            class="fixed inset-0 flex items-center justify-center p-6"
            @click.stop {{-- Prevent clicks inside from closing the modal --}}
        >
            {{-- Modal content --}}
            <div class="bg-background rounded-lg shadow-xl max-w-3xl w-full p-6 relative">
                {{-- Modal Header --}}
                <div>
                    <div class="flex justify-between items-center border-b pb-4 mb-4 border-gray-500">
                        <h2 class="text-xl font-semibold text-primary-500">
                            Review {{ $movie->title }}
                        </h2>
                        <button
                            type="button"
                            x-on:click="$wire.showModal = false;confirm('Are you sure you want to cancel?');"
                            class="text-gray-400 hover:text-primary-500 absolute top-4 right-8"
                        >
                            <x-icon-close class="w-6 h-6"/>
                        </button>
                    </div>
                </div>

                {{-- Begin form --}}
                <form
                    wire:submit="save"
                >

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600 text-xs mt-2 mb-4">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- Watch --}}
                    <x-watch-date :movie="$movie"/>

                    {{-- Review Text --}}
                    <div class="mt-4">
                        <x-form-label for="review_content" value="Review">Review</x-form-label>
                        <x-form-textarea name="review_content" rows="10" class="w-full" wire:model="reviewContent"
                        />
                        <x-form-error name="review_content"/>

                        <x-form-checkbox name="contains_spoilers">Contains Spoilers</x-form-checkbox>
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
