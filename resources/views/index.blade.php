<x-app>
    <x-slot:title>
        Home | Reeltrack
    </x-slot:title>
    <div class="relative">
        <!-- Background gradient -->
        <div class="absolute min-h-screen inset-x-0 -z-10">
            <div class="min-h-screen bg-linear-to-b from-primary-900/50 bg-no-repeat"></div>
        </div>

        <!-- Anime.js animation container -->
        <div id="animation-container" class="absolute inset-0 -z-5">
            <!-- Circles will be dynamically added here -->
        </div>

        <!-- Hero Section -->
        <div class="relative z-10 flex flex-col min-h-screen justify-center">
            <div class="flex flex-col justify-center">
                <div>
                    <h1 class="text-8xl font-bold text-center mb-6">Reeltrack</h1>
                    <p class="text-xl font-medium text-center text-primary-200">Movies and TV. All in one place.</p>
                    <p class="text-xl font-medium text-center text-primary-200">Add movies and TV shows to your
                        watchlist,
                        track your progress, and get recommendations.</p>
                </div>

                <div class="mt-12 text-center flex flex-row justify-center space-x-4">
                    <button class="inline-block px-8 py-4 bg-primary-600
                hover:bg-primary-500 text-white font-bold rounded-lg transform transition hover:scale-105
                hover:rotate-1">Browse Movies
                    </button>

                    <button class="inline-block px-8 py-4 bg-primary-600
                hover:bg-primary-500 text-white font-bold rounded-lg transform transition hover:scale-105
                hover:rotate-1">Browse Shows
                    </button>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="container mt-40">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Track Card -->
                    <div class="bg-primary-800/30 p-6 rounded-lg backdrop-blur-sm border border-primary-700">
                        <div class="text-primary-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Track Everything</h3>
                        <p class="text-neutral-300">Keep a record of every movie and show you've watched, want to watch,
                            or
                            are currently watching.</p>
                    </div>

                    <!-- Discover Card -->
                    <div class="bg-primary-800/30 p-6 rounded-lg backdrop-blur-sm border border-primary-700">
                        <div class="text-primary-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Discover New Content</h3>
                        <p class="text-neutral-300">Find new movies and shows based on your watching history and
                            preferences.</p>
                    </div>

                    <!-- Share Card -->
                    <div class="bg-primary-800/30 p-6 rounded-lg backdrop-blur-sm border border-primary-700">
                        <div class="text-primary-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Share With Friends</h3>
                        <p class="text-neutral-300">Share your watchlists and recommendations with friends and
                            family.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
