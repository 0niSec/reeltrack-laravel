<x-app>
    <x-slot:title>
        Home
    </x-slot:title>

    <div class="relative mt-20">
        <!-- Hero Section -->
        <div class="relative z-10 flex flex-col container max-w-6xl justify-center">
            <div class="flex flex-col">
                <div class="w-fit">
                    <h1 class="text-8xl font-bold underline underline-offset-8">Reeltrack</h1>
                    <p class="text-2xl -mr-10 font-medium text-end text-primary-200">Movies and TV. All in one
                        place.</p>
                </div>

                <!-- Stats Section -->
                <div class="container max-w-6xl mt-4">
                    <div class="grid grid-cols-4 md:grid-cols-10">
                        <div>
                            <div class="flex items-center space-x-1">
                                <div class="block w-2 h-2 rounded-xs bg-primary-500"></div>
                                <div class="text-neutral-300 text-sm">Movies</div>
                            </div>
                            <div
                                class="text-primary-400 mb-2">
                                <span class="text-xl">{{ Number::abbreviate($siteStats['total_movies']) }}</span></div>
                        </div>

                        <div>
                            <div class="flex items-center space-x-1">
                                <div class="block w-2 h-2 rounded-xs bg-accent-500"></div>
                                <div class="text-neutral-300 text-sm">Users</div>
                            </div>
                            <div
                                class="text-primary-400 mb-2">
                                <span class="text-xl">{{ Number::abbreviate($siteStats['total_users']) }}</span></div>
                        </div>

                        <div>
                            <div class="flex items-center space-x-1">
                                <div class="block w-2 h-2 rounded-xs bg-cyan-500"></div>
                                <div class="text-neutral-300 text-sm">Reviews</div>
                            </div>
                            <div
                                class="text-primary-400 mb-2">
                                <span class="text-xl">{{ Number::abbreviate($siteStats['total_reviews']) }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center space-x-1">
                                <div class="block w-2 h-2 rounded-xs bg-indigo-500"></div>
                                <div class="text-neutral-300 text-sm">Ratings</div>
                            </div>
                            <div
                                class="text-primary-400 mb-2">{{ Number::abbreviate($siteStats['total_ratings']) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-12 text-center flex flex-row space-x-2 items-center">
                    <x-button-link href="{{ route('register') }}">Create a free account</x-button-link>
                    <span class="text-neutral-400">or <x-underlined-link
                            href="{{ route('login') }}">log in</x-underlined-link> if you have an account</span>
                </div>

                <!-- 🔥 What's Trending -->
                <div class="mt-12">
                    <h1 class="text-xl font-light mb-2">🔥 What's Trending</h1>
                    <div class="grid grid-cols-4 md:grid-cols-8 gap-4">
                        @foreach($trending as $movie)
                            <a href="{{ route('movies.show', $movie) }}"
                               class="hover:opacity-75 transition-opacity" wire:navigate>
                                <x-movie-card :movie="$movie"/>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Feature Descriptions -->
            <h1 class="mt-10 mb-3">What is Reeltrack?</h1>
            <p>Reeltrack is your personal cinematic companion. Easily log the movies and TV shows you watch, rate them,
                and share your thoughts with reviews and real-time reactions. Keep track of everything you've seen and
                discover new favorites.</p>


            <div class="grid grid-cols-2 gap-8 space-y-20 mt-20">
                <div class="feature-item">
                    <h1 class="mt-10 mb-3">Log Movies and TV Shows</h1>
                    <p>Log the movies and TV shows you've seen, rate them, and share your thoughts with reviews and
                        real-time reactions.</p>
                </div>
                <img src="{{ asset('images/log_movies.png') }}" alt="Log Movies" class="border border-neutral-500">

                <div class="feature-item order-last">
                    <h1 class="mt-10 mb-3">Create and Organize Lists</h1>
                    <p>Create and curate custom lists for your movie and TV show adventures. Organize your favorites,
                        keep track of must-watch titles, and share them with friends!</p>
                </div>
                <img src="{{ asset('images/log_movies.png') }}" alt="Log Movies" class="border border-neutral-500">
            </div>

        </div>
    </div>
</x-app>
