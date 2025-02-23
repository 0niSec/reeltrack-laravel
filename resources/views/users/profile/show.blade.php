@php use Carbon\Carbon; @endphp
<x-app>
    <x-slot:title>{{ $user->username }}'s Profile</x-slot:title>

    @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            class="absolute bg-green-600 rounded-md p-4 w-auto max-w-md h-auto max-h-32 top-25 left-1/2
            transform
            -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center">
            <div class="alert flex items-center">
                <x-icon-check-circle class="w-8 h-8 mr-4"/> {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="container max-w-6xl mx-auto min-h-screen space-y-10">

        <!-- Top container/stats -->
        <div class="flex justify-between items-center mt-10">
            <!-- Username, avatar, edit profile button -->
            <div class="flex items-center space-x-4">
                @if($user->profile->avatar)
                    <img src="{{ Storage::url($user->profile->avatar) }}" alt="Profile Photo"
                         class="rounded-full h-20 w-20 object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ $user->username }}&size=128"
                         alt="Default Avatar" class="rounded-full h-20 w-20 object-cover">
                @endif
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ $user->username }}
                    </h1>
                    <p class="text-sm text-gray-500">Member since {{ $user->created_at->year }}</p>
                </div>
                @can('edit', $user->profile)
                    <a href="{{ route('settings.profile')}}" class="flex
                    items-center
            space-x-2 text-xs p-2 bg-gray-700 rounded-lg shadow-xl inset-shadow-2xs font-bold hover:bg-gray-600
            transition-all ease-in-out">Edit Profile</a>
                @endcan
            </div>

            <!-- User Stats -->
            <div id="user-stats" class="flex items-center space-x-4">
                <div class="flex items-center space-x-8">
                    <!-- TODO: Add data from db -->
                    <!-- Films -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium text-gray-300">0</span>
                        <span class="block text-sm font-thin text-gray-500">Films</span>
                    </div>
                    <!-- TV -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium text-gray-300">0</span>
                        <span class="block text-sm font-thin text-gray-500">TV</span>
                    </div>
                    <!-- This Week -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium text-gray-300">0</span>
                        <span class="block text-sm font-thin text-gray-500">This Year</span>
                    </div>
                    <!-- Following -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium text-gray-300">0</span>
                        <span class="block text-sm font-thin text-gray-500">Following</span>
                    </div>
                    <!-- Followers -->
                    <div class="text-center">
                        <span class="block text-2xl font-medium text-gray-300">0</span>
                        <span class="block text-sm font-thin text-gray-500">Followers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Navigation -->
        <div class="flex justify-center items-center space-x-4 p-2 border border-gray-700">
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Profile</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Activity</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Movies</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">TV</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Reviews</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Reels</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Watchlist</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Lists</a>
            <a href="{{ route('profile', $user) }}" class="text-gray-200 hover:text-primary-400">Likes</a>
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

                <div class="space-y-4 ">
                    @forelse($user->activities as $activity)
                        <div class="flex items-center space-x-4">
                            <div>
                                <p class="text-xs text-gray-400">
                                    You
                                    @if($activity->event_type === 'watchlist')
                                        @if($activity->action === 'added')
                                            added
                                        @else
                                            removed
                                        @endif
                                        <a href="{{ $activity->subject->url() }}"
                                           class="font-medium text-gray-300 hover:text-primary-400
                                           transition-colors"
                                           wire:navigate>
                                            {{ $activity->subject->title }}
                                        </a>
                                        {{ $activity->action === 'added' ? 'to' : 'from' }} your watchlist
                                    @elseif($activity->event_type === 'review')
                                        @if($activity->action === 'created')
                                            reviewed
                                        @elseif($activity->action === 'updated')
                                            updated your review of
                                        @else
                                            removed your review from
                                        @endif
                                        <a href="{{ $activity->subject->url() }}"
                                           class="font-medium text-gray-300 hover:text-primary-400 transition-colors"
                                           wire:navigate>
                                            {{ $activity->subject->title }}
                                        </a>
                                    @elseif($activity->event_type === 'rating')
                                        @if($activity->action === 'rated')
                                            rated
                                        @endif
                                        <a href="{{ $activity->subject->url() }}"
                                           class="font-medium text-gray-300 hover:text-primary-400 transition-colors"
                                           wire:navigate>
                                            {{ $activity->subject->title }}
                                        </a>

                                        @for ($i = 1; $i <= $activity->metadata['rating']; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="inline-block h-4 w-4 {{ $i <= floor($activity->metadata['rating']) ? 'text-yellow-500' : ($i - 0.5 <= $activity->metadata['rating'] ? 'text-yellow-300' : 'text-gray-500') }}"
                                                 viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.908c.969 0 1.371 1.244.588 1.81l-3.98 2.942a1 1 0 00-.36 1.118l1.519 4.674c.3.921-.755 1.688-1.54 1.118l-3.98-2.942a1 1 0 00-1.175 0l-3.98 2.942c-.785.57-1.84-.197-1.54-1.118l1.519-4.674a1 1 0 00-.36-1.118L2.44 10.1c-.783-.566-.38-1.81.588-1.81h4.908a1 1 0 00.95-.69l1.518-4.674z"/>
                                            </svg>
                                        @endfor
                                        @if(fmod($activity->metadata['rating'], 1) !== 0)
                                            <span class="text-xs text-yellow-300">½</span>
                                        @endif
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ Carbon::parse($activity->created_at)->diffInMinutes() < 5 ? 'Just now' :
                                        (Carbon::parse($activity->created_at)->diffInDays() > 7 ?
                                            Carbon::parse($activity->created_at)->format('M d, Y') :
                                            Carbon::parse($activity->created_at)->diffForHumans()) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">
                            No recent activities to display.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app>
