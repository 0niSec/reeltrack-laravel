<x-app>
    <x-slot:title>{{ $user->username }}'s Profile</x-slot:title>

    <div class="container max-w-6xl mx-auto min-h-screen space-y-10">

        <!-- Top container/stats -->
        <div class="flex justify-between items-center mt-10">
            <!-- Username, avatar, edit profile button -->
            <div class="flex items-center space-x-4">
                @if($user->profile->avatar)
                    <img src="{{ $user->profile->id }}" alt="Profile Photo" class="rounded-full h-20 w-20 object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&size=128"
                         alt="Default Avatar" class="rounded-full h-20 w-20 object-cover">
                @endif
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ $user->username }}
                    </h1>
                    <p class="text-sm text-zinc-500">Member since {{ $user->created_at->year }}</p>
                </div>
                @can('edit', $user->profile)
                    <a href="{{ route('settings.profile')}}" class="flex
                    items-center
            space-x-2 text-xs p-2 bg-zinc-700 rounded-lg shadow-xl inset-shadow-2xs font-bold hover:bg-zinc-600
            transition-all ease-in-out">Edit Profile</a>
                @endcan
            </div>

            <!-- User Stats -->
            <div id="user-stats" class="flex items-center space-x-4">
                <div class="flex items-center space-x-8">
                    <!-- TODO: Add data from db -->
                    <!-- Films -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm font-thin text-zinc-500">Films</span>
                    </div>
                    <!-- TV -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm font-thin text-zinc-500">TV</span>
                    </div>
                    <!-- This Week -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm font-thin text-zinc-500">This Year</span>
                    </div>
                    <!-- Following -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm font-thin text-zinc-500">Following</span>
                    </div>
                    <!-- Followers -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm font-thin text-zinc-500">Followers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Navigation -->
        <div class="flex justify-center items-center space-x-4 p-2 border border-zinc-700">
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Profile</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Activity</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Movies</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">TV</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Reviews</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Reels</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Watchlist</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Lists</a>
            <a href="{{ route('profile', $user) }}" class="text-zinc-200 hover:text-primary-400">Likes</a>
        </div>

        <!-- Favorites Grid Container -->
        <div class="grid grid-cols-14 grid-flow-row gap-4">
            <div class="col-span-10 space-y-10">

                <!-- Favorite Movies -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Favorite Movies'"/>
                </div>

                <!-- Favorite Shows -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Favorite Shows'"/>
                </div>

                <!-- Recent Likes -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Recent Likes'"/>
                    <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(175px,1fr))] gap-x-4 gap-y-4">
                        @foreach($user->likes->where('status', true) as $like)
                            <a href="{{ route('movies.show', ['movie' => $like->likeable]) }}" wire:navigate>
                                <x-movie-card :movie="$like->likeable"/>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Recent Reviews'"/>
                </div>
            </div>

            <div class="col-span-4">
                <x-display-heading href="#" :heading="'Activity'"/>
            </div>

        </div>
    </div>
</x-app>
