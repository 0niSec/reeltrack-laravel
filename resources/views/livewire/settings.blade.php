<div class="container max-w-6xl mt-10">
    <x-slot:heading>Profile Settings</x-slot:heading>

    @if(session('success'))
        <div
            class="absolute bg-green-800 rounded-md p-4 w-auto max-w-md h-auto max-h-32 top-25 left-1/2
            transform
            -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center" x-data="{ showSuccess: true }"
            x-show="showSuccess"
            x-init="setTimeout(() => showSuccess = false, 5000)">
            <div class="alert flex items-center">
                <x-icon-check-circle class="w-8 h-8 mr-4"/> {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div
            class="absolute bg-red-800 rounded-md p-4 w-auto max-w-md h-auto max-h-32 top-25 left-1/2
            transform
            -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center" x-data="{ showError: true }"
            x-show="showError"
            x-init="setTimeout(() => showError = false, 5000)">
            <div class="alert flex items-center">
                <x-icon-error-circle class="w-8 h-8 mr-4"/> {{ session('error') }}
            </div>
        </div>
    @endif

    <form wire:submit="save" enctype="multipart/form-data"
    >
        <div class="grid grid-cols-2 gap-x-20 mt-8">
            <div class="space-y-4">
                <h2 class="text-xl font-thin mb-4 text-primary-500">Profile</h2>

                <!-- Avatar -->
                <div>
                    <x-form-label for="avatar">Avatar</x-form-label>
                    @if ($user->profile->avatar)
                        <img src="{{ Storage::url($user->profile->avatar) }}" alt="Current Avatar" class="w-20 h-20
                    rounded-full object-cover mb-4"/>
                    @else
                        <p class="mb-2">No avatar uploaded!</p>
                    @endif
                    <x-file-input-small wire:model="avatar" name="avatar" accept="image/*"/>
                    <x-form-error name="avatar"/>
                </div>

                <!-- Nickname -->
                <div>
                    <x-form-label for="nickname">Nickname</x-form-label>
                    <x-form-input-small type="text" wire:model="nickname" name="nickname" placeholder="John"
                                        :value="old('nickname', $user->profile->nickname)"/>
                </div>

                <!-- Bio -->
                <div>
                    <x-form-label for="bio">Bio</x-form-label>
                    <x-form-textarea name="bio" wire:model="bio" autocomplete="true"
                                     :value="old('bio')"
                    />
                    <x-form-error name="bio"/>
                </div>

                <div>
                    <x-form-label for="website">Website</x-form-label>
                    <x-form-input-small type="text" wire:model="website" name="website" :value="old('website')"
                                        placeholder="https://example.com"/>
                    <x-form-error name="website"/>
                </div>

                <!-- Socials -->
                <h2 class="text-xl font-thin mb-4 text-primary-500">Socials</h2>
                <div>
                    <x-form-label for="x">Twitter</x-form-label>
                    <x-form-input-small type="text" wire:model="twitter" name="twitter" placeholder="@reeltrack"
                                        :value="old('twitter')"/>
                    <x-form-error name="twitter"/>
                </div>

                <div>
                    <x-form-label for="facebook">Facebook</x-form-label>
                    <x-form-input-small type="text" wire:model="facebook" name="facebook" placeholder="John Wick"
                                        :value="old('facebook')"/>
                    <x-form-error name="facebook"/>
                </div>

                <div>
                    <x-form-label for="instagram">Instagram</x-form-label>
                    <x-form-input-small type="text" wire:model="instagram" name="instagram" placeholder="@reeltrack"
                                        :value="old('instagram')"/>
                    <x-form-error name="instagram"/>
                </div>

                <div>
                    <x-form-label for="bluesky">Bluesky</x-form-label>
                    <x-form-input-small type="text" wire:model="bluesky" name="bluesky"
                                        placeholder="@reeltrack.bsky.social"
                                        :value="old('bluesky')"/>
                    <x-form-error name="bluesky"/>
                </div>

                <div>
                    <x-form-label for="youtube">Youtube</x-form-label>
                    <x-form-input-small type="text" wire:model="youtube" name="youtube" :value="old('youtube')"
                                        placeholder="reeltrack"/>
                    <x-form-error name="youtube"/>
                </div>

                <div>
                    <x-form-label for="tiktok">TikTok</x-form-label>
                    <x-form-input-small type="text" wire:model="tiktok" name="tiktok" :value="old('tiktok')"/>
                    <x-form-error name="tiktok"/>
                </div>
            </div>

            <!-- TODO: This works but we can maybe actually open the modal with Alpine still, but communicate
                changes with Livewire -->
            <div class="col-start-2">
                <x-form-label for="favorite_movies">Favorite Movies</x-form-label>
                <div class="flex flex-row space-x-2 w-full">
                    @for($i = 1; $i <= 4; $i++)
                        <livewire:favorite-movie-card wire:key="movie-card-{{$i}}"/>
                    @endfor
                </div>
            </div>
        </div>
        <x-form-submit-button class="mt-8 w-auto">Save</x-form-submit-button>
    </form>
</div>
