<x-app>
    <x-slot:title>Profile Settings</x-slot:title>
    <div class="container max-w-6xl mt-10">
        <h1 class="font-thin">Profile Settings</h1>

        <form action="{{ route('profile.settings.update', $user) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 gap-x-20 mt-8">
                <div class="space-y-4">
                    <h2 class="text-xl font-thin mb-4 text-primary-500">Profile</h2>

                    <!-- Avatar -->
                    <div>
                        <x-form-label for="avatar">Avatar</x-form-label>
                        <x-file-input-small name="avatar" accept="image/*"/>
                        <x-form-error name="avatar"/>
                    </div>

                    <!-- Nickname -->
                    <div>
                        <x-form-label for="nickname">Nickname</x-form-label>
                        <x-form-input-small type="text" name="nickname" placeholder="John"
                                            :value="old('nickname', $user->nickname)"/>
                    </div>

                    <!-- Bio -->
                    <div x-data="{ bioText: '' }">
                        <x-form-label for="bio">Bio</x-form-label>
                        <x-form-textarea name="bio" autocomplete="true" x-model="bioText"
                                         :value="old('bio', $user->bio)"/>
                        <x-form-error name="bio"/>
                    </div>

                    <div>
                        <x-form-label for="website">Website</x-form-label>
                        <x-form-input-small type="text" name="website" :value="old('website', $user->website)"
                                            placeholder="https://example.com"/>
                        <x-form-error name="website"/>
                    </div>

                    <!-- Socials -->
                    <h2 class="text-xl font-thin mb-4 text-primary-500">Socials</h2>
                    <div>
                        <x-form-label for="x">Twitter</x-form-label>
                        <x-form-input-small type="text" name="twitter" placeholder="@reeltrack" :value="old('twitter',
                        $user->twitter)"/>
                        <x-form-error name="twitter"/>
                    </div>

                    <div>
                        <x-form-label for="facebook">Facebook</x-form-label>
                        <x-form-input-small type="text" name="facebook" placeholder="John Wick"
                                            :value="old('facebook', $user->facebook)"/>
                        <x-form-error name="facebook"/>
                    </div>

                    <div>
                        <x-form-label for="instagram">Instagram</x-form-label>
                        <x-form-input-small type="text" name="instagram" placeholder="@reeltrack"
                                            :value="old('instagram', $user->instagram)"/>
                        <x-form-error name="instagram"/>
                    </div>

                    <div>
                        <x-form-label for="bluesky">Bluesky</x-form-label>
                        <x-form-input-small type="text" name="bluesky" placeholder="@reeltrack.bsky.social"
                                            :value="old('bluesky', $user->bluesky)"/>
                        <x-form-error name="bluesky"/>
                    </div>

                    <div>
                        <x-form-label for="youtube">Youtube</x-form-label>
                        <x-form-input-small type="text" name="youtube" :value="old('youtube', $user->youtube)"
                                            placeholder="reeltrack"/>
                        <x-form-error name="youtube"/>
                    </div>

                    <div>
                        <x-form-label for="tiktok">TikTok</x-form-label>
                        <x-form-input-small type="text" name="tiktok" :value="old('tiktok', $user->tiktok)"/>
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

                        {{-- Modal --}}
                        <livewire:favorite-movie-modal/>
                    </div>
                </div>
                <x-form-submit-button class="mt-10 w-1/2">Save</x-form-submit-button>
            </div>

        </form>
    </div>


</x-app>
