@php use Carbon\Carbon; @endphp
<x-app>
    <x-slot:title>
        Home
    </x-slot:title>

    <!-- Hero Section with Background Gradient -->
    <div class="relative min-h-screen pb-20">
        <div
            class="absolute inset-0 bg-gradient-to-br from-neutral-900 via-neutral-900 to-primary-900 opacity-50 -z-10"></div>

        <div class="pt-32 px-4 sm:px-6 lg:px-8">
            <!-- Main Content Container -->
            <div class="max-w-6xl mx-auto">
                <!-- Hero Header -->
                <div class="text-center sm:text-left mb-16">
                    <h1 class="text-5xl sm:text-7xl md:text-8xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-accent-400 pb-2">
                        Reeltrack</h1>
                    <p class="text-xl sm:text-2xl text-neutral-200 mt-4 max-w-xl sm:ml-2">Movies and TV. All in one
                                                                                          place.</p>

                    <!-- CTA Buttons -->
                    <div
                        class="mt-10 flex flex-col sm:flex-row gap-4 items-center justify-center sm:justify-start sm:ml-2">
                        <div class="flex flex-row space-x-4">
                            <x-button-link href="{{ route('register') }}"
                                           class="px-8 py-3 text-lg shadow-lg shadow-primary-500/20">
                                Get Started
                                <x-icon-arrow-right class="inline ml-2 h-5 w-5"/>
                            </x-button-link>
                        </div>
                        <span class="inline-flex ml-2 text-neutral-400">Already have an account?</span>
                        <x-underlined-link href="{{ route('login') }}"
                                           class="flex items-center justify-center text-neutral-200 hover:text-primary-400 transition-colors">
                            Login
                        </x-underlined-link>
                    </div>
                </div>

                <!-- Feature Highlights -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                    <div
                        class="bg-neutral-800/50 backdrop-blur-sm rounded-2xl p-6 transform transition hover:scale-105">
                        <div class="p-3 rounded-full bg-primary-500/20 w-fit mb-4">
                            <x-icon-film class="w-6 h-6 text-primary-400"/>
                        </div>
                        <h3 class="text-xl font-semibold text-neutral-100 mb-2">Track Your Watchlist</h3>
                        <p class="text-neutral-400">Keep track of what you want to watch and what you've already
                                                    seen.</p>
                    </div>

                    <div
                        class="bg-neutral-800/50 backdrop-blur-sm rounded-2xl p-6 transform transition hover:scale-105">
                        <div class="p-3 rounded-full bg-accent-500/20 w-fit mb-4">
                            <x-icon-star class="w-6 h-6 text-accent-400"/>
                        </div>
                        <h3 class="text-xl font-semibold text-neutral-100 mb-2">Rate & Review</h3>
                        <p class="text-neutral-400">Share your thoughts and see what others think about your favorite
                                                    films.</p>
                    </div>

                    <div
                        class="bg-neutral-800/50 backdrop-blur-sm rounded-2xl p-6 transform transition hover:scale-105">
                        <div class="p-3 rounded-full bg-cyan-500/20 w-fit mb-4">
                            <x-icon-users class="w-6 h-6 text-cyan-400"/>
                        </div>
                        <h3 class="text-xl font-semibold text-neutral-100 mb-2">Join the Community</h3>
                        <p class="text-neutral-400">Connect with other movie enthusiasts and discover new content
                                                    together.</p>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="relative mb-20">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-primary-500/10 to-accent-500/10 rounded-3xl -z-10"></div>
                    <div class="backdrop-blur-sm bg-neutral-800/30 rounded-3xl p-8 border border-neutral-700/50">
                        <h2 class="text-2xl font-bold text-neutral-100 mb-8 text-center">Community Stats</h2>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                            <!-- Movies Stat -->
                            <div class="flex flex-col items-center">
                                <div class="radial-progress-container mb-3 relative">
                                    <svg class="w-24 h-24">
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke="rgba(255,255,255,0.1)"
                                                fill="transparent"></circle>
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke-dasharray="226"
                                                stroke-dashoffset="56"
                                                stroke="rgba(var(--color-primary-500))" fill="transparent"
                                                class="progress-ring"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="text-2xl font-bold text-primary-400">{{ Number::abbreviate($siteStats['total_movies']) }}</span>
                                    </div>
                                </div>
                                <span class="text-lg font-medium text-neutral-200">Movies</span>
                            </div>

                            <!-- Users Stat -->
                            <div class="flex flex-col items-center">
                                <div class="radial-progress-container mb-3 relative">
                                    <svg class="w-24 h-24">
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke="rgba(255,255,255,0.1)"
                                                fill="transparent"></circle>
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke-dasharray="226"
                                                stroke-dashoffset="113"
                                                stroke="rgba(var(--color-accent-500))" fill="transparent"
                                                class="progress-ring"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="text-2xl font-bold text-accent-400">{{ Number::abbreviate($siteStats['total_users']) }}</span>
                                    </div>
                                </div>
                                <span class="text-lg font-medium text-neutral-200">Users</span>
                            </div>

                            <!-- Reviews Stat -->
                            <div class="flex flex-col items-center">
                                <div class="radial-progress-container mb-3 relative">
                                    <svg class="w-24 h-24">
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke="rgba(255,255,255,0.1)"
                                                fill="transparent"></circle>
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke-dasharray="226"
                                                stroke-dashoffset="85"
                                                stroke="rgba(var(--color-cyan-500))" fill="transparent"
                                                class="progress-ring"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="text-2xl font-bold text-cyan-400">{{ Number::abbreviate($siteStats['total_reviews']) }}</span>
                                    </div>
                                </div>
                                <span class="text-lg font-medium text-neutral-200">Reviews</span>
                            </div>

                            <!-- Ratings Stat -->
                            <div class="flex flex-col items-center">
                                <div class="radial-progress-container mb-3 relative">
                                    <svg class="w-24 h-24">
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke="rgba(255,255,255,0.1)"
                                                fill="transparent"></circle>
                                        <circle cx="48" cy="48" r="36" stroke-width="8" stroke-dasharray="226"
                                                stroke-dashoffset="70"
                                                stroke="rgba(var(--color-indigo-500))" fill="transparent"
                                                class="progress-ring"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="text-2xl font-bold text-indigo-400">{{ Number::abbreviate($siteStats['total_ratings']) }}</span>
                                    </div>
                                </div>
                                <span class="text-lg font-medium text-neutral-200">Ratings</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What's Trending Section -->
                <div class="mb-16">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl md:text-3xl font-bold text-neutral-100 flex items-center gap-2">
                            <span class="text-primary-500">
                                <x-icon-trending-up class="w-8 h-8 inline-block"/>
                            </span>
                            What's Trending
                        </h2>
                        <a href="#"
                           class="text-primary-400 hover:text-primary-300 transition-colors flex items-center gap-1">
                            View all
                            <x-icon-arrow-right class="w-4 h-4"/>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-6">
                        @foreach($trending as $movie)
                            <a href="{{ route('movies.show', $movie) }}"
                               class="group relative rounded-lg overflow-hidden shadow-lg transform transition-all duration-300 hover:scale-105 hover:-translate-y-1"
                               wire:navigate>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                                    <div class="text-white font-medium line-clamp-2 text-sm">{{ $movie->title }}</div>
                                </div>
                                <x-movie-card :movie="$movie"/>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Genre Spotlights -->
                <div class="mb-16 bg-neutral-800/50 backdrop-blur-sm rounded-2xl p-8 border border-neutral-700/50">
                    <h2 class="text-2xl md:text-3xl font-bold text-neutral-100 mb-6 flex items-center gap-2">
        <span class="text-accent-500">
            <x-icon-compass class="w-7 h-7 inline-block"/>
        </span>
                        Genre Spotlights
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($genreSpotlights->take(2) as $index => $movie)
                            <div class="relative rounded-xl overflow-hidden group cursor-pointer h-48">
                                <div class="absolute inset-0 bg-gradient-to-r
                    {{ $index % 2 == 0 ? 'from-primary-800/80 to-primary-900/50' : 'from-accent-700/80 to-accent-700/50' }}
                    group-hover:opacity-90 transition-opacity z-10">
                                </div>
                                <img src="{{ $movie->backdrop_path }}" alt="{{ $movie->title }}"
                                     class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

                                <div class="absolute inset-0 z-20 flex flex-col justify-end p-5"
                                >
                                    <h3 class="font-bold text-white text-xl mb-1
                        group-hover:{{ $index % 2 == 0 ? 'text-primary-300' : 'text-accent-300' }} transition-colors">
                                        {{ $movie->genre }}
                                    </h3>
                                    <p class="text-neutral-200 text-sm line-clamp-2">
                                        Featuring: {{ $movie->title }}
                                        ({{ Carbon::parse($movie->release_date)->format('Y') }})
                                    </p>
                                    <div class="mt-3 flex items-center">
                        <span class="text-xs text-white/70 flex items-center gap-1.5">
                            <x-icon-film class="w-4 h-4"/> {{ $movie->watch_count ?? 0 }} watches
                        </span>
                                        <span class="mx-2 text-white/30">•</span>
                                        <span class="text-xs text-white/70 flex items-center gap-1.5">
                            <x-icon-star class="w-4 h-4"/> {{ number_format($movie->avg_rating ?? 0, 1) }} avg rating
                        </span>
                                    </div>
                                    <div class="h-0.5 w-full bg-white/10 mt-3 overflow-hidden">
                                        <div
                                            class="h-full {{ $index % 2 == 0 ? 'bg-primary-400' : 'bg-accent-400' }} w-{{ min(round(($movie->avg_rating ?? 0) * 10), 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 p-6 text-center text-neutral-400">
                                No genre spotlights available yet. Add more movies to get personalized recommendations!
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        @foreach($genreSpotlights->skip(2)->take(4) as $movie)
                            <a href="{{ route('movies.index', ['genre' => $movie->genre]) }}"
                               class="px-4 py-2 rounded-full bg-neutral-700/50 hover:bg-neutral-700 transition-colors text-sm text-neutral-300 flex items-center gap-2">
                                <x-dynamic-component
                                    :component="'icon-' . strtolower(str_replace(' ', '-', $movie->genre))"
                                    class="w-4 h-4" fallback="icon-film"/>
                                {{ $movie->genre }}
                            </a>
                        @endforeach

                        <a href="{{ route('movies.index') }}"
                           class="px-4 py-2 rounded-full bg-primary-500/20 hover:bg-primary-500/30 transition-colors text-sm text-primary-300 flex items-center gap-2">
                            <x-icon-add class="w-4 h-4"/>
                            View All Genres
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
