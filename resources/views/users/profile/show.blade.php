@php use App\Models\Movie;use App\Models\TvShow;use Carbon\Carbon; @endphp
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
                    <!-- Films -->
                    <div class="text-center">
            <span class="block text-2xl font-medium text-gray-300">
                {{ $stats['films_count'] }}
            </span>
                        <span class="block text-sm font-thin text-gray-500">Films</span>
                    </div>
                    <!-- TV -->
                    <div class="text-center">
            <span class="block text-2xl font-medium text-gray-300">
                {{ $stats['tv_count'] }}
            </span>
                        <span class="block text-sm font-thin text-gray-500">TV</span>
                    </div>
                    <!-- This Year -->
                    <div class="text-center">
            <span class="block text-2xl font-medium text-gray-300">
                {{ $stats['this_year_count'] }}
            </span>
                        <span class="block text-sm font-thin text-gray-500">This Year</span>
                    </div>
                    <!-- Following -->
                    <div class="text-center">
            <span class="block text-2xl font-medium text-gray-300">
                0
            </span>
                        <span class="block text-sm font-thin text-gray-500">Following</span>
                    </div>
                    <!-- Followers -->
                    <div class="text-center">
            <span class="block text-2xl font-medium text-gray-300">
                0
            </span>
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
                    <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(175px,1fr))] gap-x-4 gap-y-4">
                        {{-- TODO: Implement --}}
                    </div>
                </div>

                <!-- Favorite Shows -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Favorite Shows'"/>
                </div>

                <!-- Recent Like -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Recent Likes'"/>
                    <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(175px,1fr))] gap-x-4 gap-y-4">
                        @foreach($likedMovies as $movie)
                            <a href="{{ route('movies.show', $movie) }}">
                                <x-movie-card :movie="$movie"/>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="flex flex-col">
                    <x-display-heading href="#" :heading="'Recent Reviews'"/>
                    <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(175px,1fr))] gap-x-4 gap-y-4">
                        @foreach($recentReviews as $review)
                            <a href="{{ route('movies.show', $review->reviewable) }}">
                                <x-movie-card :movie="$review->reviewable"/>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-span-4">
                <x-display-heading href="#" :heading="'Activity'"/>

                <!-- Activity Feed -->
                <!-- TODO: Make this a component -->
                {{--                <div class="flex flex-col space-y-2">--}}
                {{--                    @forelse($recentActivities as $activity)--}}
                {{--                        <div>--}}
                {{--                            @php--}}
                {{--                                $properties = $activity->properties ?? [];--}}
                {{--                                $subject = $activity->subjectable;--}}
                {{--                                $actionText = '';--}}

                {{--                                $rating = $properties['rating'];--}}
                {{--                                $fullStars = 0;--}}
                {{--                                $hasHalfStar = 0;--}}

                {{--                                $timeAgo = Carbon::parse($activity->created_at)->diffForHumans();--}}

                {{--                                switch($activity->action) {--}}
                {{--                                    case 'reeled':--}}
                {{--                                        $actions = [];--}}
                {{--                                        if (isset($properties['is_liked'])) {--}}
                {{--                                            $actions[] = 'liked';--}}
                {{--                                        }--}}
                {{--                                        if (isset($properties['rating'])) {--}}
                {{--                                            $actions[] = "rated";--}}
                {{--                                            $fullStars = floor($properties['rating']);--}}
                {{--                                            $hasHalfStar = $rating - $fullStars >= 0.5; // TODO: Fix--}}
                {{--                                        }--}}
                {{--                                        if (!empty($properties['review_content'])) {--}}
                {{--                                            $actions[] = "reviewed";--}}
                {{--                                        }--}}

                {{--                                        // If there's only one item, return it as is--}}
                {{--                                        if (count($actions) === 1) {--}}
                {{--                                            $actionText = $actions[0];--}}
                {{--                                        }--}}
                {{--                                        // If there are two items, join with "and"--}}
                {{--                                        elseif (count($actions) === 2) {--}}
                {{--                                            $actionText = implode(' and ', $actions);--}}
                {{--                                        }--}}
                {{--                                        // For three or more items, use Oxford comma with "and"--}}
                {{--                                        else {--}}
                {{--                                            $lastAction = array_pop($actions);--}}
                {{--                                            $actionText = implode(', ', $actions) . ', and ' . $lastAction;--}}
                {{--                                        }--}}
                {{--                                        break;--}}

                {{--                                    case 'rated':--}}
                {{--                                        $actionText = "rated";--}}
                {{--                                        break;--}}
                {{--                                }--}}
                {{--                            @endphp--}}

                {{--                            <div class="flex-col items-center text-xs">--}}
                {{--                                <p>--}}
                {{--                                    @if(auth()->user())--}}
                {{--                                        You--}}
                {{--                                    @else--}}
                {{--                                        {{ $user->username }}--}}
                {{--                                    @endif--}}
                {{--                                    {{ $actionText }}--}}
                {{--                                    @if($subject)--}}
                {{--                                        <a href="{{ $subject instanceof Movie--}}
                {{--                        ? route('movies.show', $subject)--}}
                {{--                        : route('tv.show', $subject) }}"--}}
                {{--                                           class="text-blue-400 hover:underline">--}}
                {{--                                            {{ $subject->title }}--}}
                {{--                                        </a>--}}
                {{--                                    @endif--}}
                {{--                                    <!-- TODO: Add star rating -->--}}
                {{--                                </p>--}}
                {{--                                @if(isset($timeAgo))--}}
                {{--                                    <span class="text-gray-500">{{ $timeAgo }}</span>--}}
                {{--                                @endif--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    @empty--}}
                {{--                        <div class="text-center text-gray-500">--}}
                {{--                            No activity yet--}}
                {{--                        </div>--}}
                {{--                    @endforelse--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
</x-app>
