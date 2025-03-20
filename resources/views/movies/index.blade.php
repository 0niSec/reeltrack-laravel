@php
    // Equivalent to setting variables in ERB
    $currentYear = now()->year;
    // Round down to the nearest decade
    $currentDecade = (intdiv($currentYear, 10) * 10);

    // Build the array of decades from the currentDecade down to 1920
    $decades = [];
    for ($year = $currentDecade; $year >= 1920; $year -= 10) {
        $decades[] = [
            'text' => $year . 's',
            'path' => url('/movies?decade=' . $year),
        ];
    }

    $movies = $movies ?? [];
@endphp

{{-- Filters --}}
<x-app>
    <x-slot:title>
        Movies
    </x-slot:title>

    <div class="container max-w-6xl my-10 flex flex-row items-center space-x-2">
        <span class="font-medium">Browse By</span>

        {{-- Year --}}
        @include('movies.partials.dropdown', [
            'button_text' => 'Year',
            'menu_items' => array_merge(
                [
                    ['text' => 'All',      'path' => url('/movies?filter=all')],
                    ['text' => 'Upcoming', 'path' => url('/movies?filter=upcoming')],
                ],
                $decades
            ),
        ])

        {{-- Rating --}}
        @include('movies.partials.dropdown', [
            'button_text' => 'Rating',
            'menu_items' => [
                ['text' => 'All',          'path' => url('/movies?filter=all')],
                ['text' => 'Highest first','path' => url('/movies?rating=highest')],
                ['text' => 'Lowest first', 'path' => url('/movies?rating=lowest')],
            ],
        ])

        {{-- Genre --}}
        @include('movies.partials.dropdown', [
            'button_text' => 'Genre',
            'menu_items' => [
                ['text' => 'All',        'path' => url('/movies?filter=all')],
                ['text' => 'Action',     'path' => url('/movies?genre=action')],
                ['text' => 'Adventure',  'path' => url('/movies?genre=adventure')],
            ],
        ])

        {{-- Popular --}}
        @include('movies.partials.dropdown', [
            'button_text' => 'Popular',
            'menu_items' => [
                ['text' => 'All time',  'path' => url('/movies?filter=popular&period=all')],
                ['text' => 'This week', 'path' => url('/movies?filter=popular&period=week')],
                ['text' => 'This month','path' => url('/movies?filter=popular&period=month')],
                ['text' => 'This year', 'path' => url('/movies?filter=popular&period=year')],
            ],
        ])
    </div>

    {{-- Popular --}}
    <div class="px-4 py-10 flex flex-col space-y-20">
        {{-- Popular Movies - Horizontal Slider --}}
        <div class="container mx-auto max-w-6xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold tracking-tight">What's popular?</h2>
                <a href="{{route('movies.popular')}}"
                   class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 flex items-center gap-1 font-medium">
                    View all
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>

            @if (count($movies['popular']) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4">
                    @foreach ($movies['popular'] as $movie)
                        <div class="">
                            <a href="{{ route('movies.show', $movie) }}" class="block">
                                <div
                                    class="rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                                    <x-movie-card :movie="$movie"/>
                                </div>
                            </a>
                            <div class="mt-1">
                                <x-mini-stats-row :stats="$movie"/>
                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                <div class="bg-white dark:bg-neutral-800 rounded-xl p-10 text-center">
                    <p class="text-primary-400">No popular movies available</p>
                </div>
            @endif
        </div>

        {{-- New Releases - Featured Cards --}}
        <div class="container mx-auto max-w-6xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold tracking-tight">New this week</h2>
                <a href="{{route('movies.new')}}"
                   class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 flex items-center gap-1 font-medium">
                    View all
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>

            <!-- Newest -->
            @if (count($movies['newest']) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach ($movies['newest'] as $movie)
                        <div class="rounded-xl shadow-md">
                            <a href="{{ route('movies.show', $movie) }}" wire:navigate class="block">
                                <div class="relative">
                                    <x-movie-card :movie="$movie"/>
                                    <div
                                        class="absolute top-2 left-2 bg-primary-600 text-white text-xs px-2 py-1 rounded-md">
                                        New
                                    </div>
                                </div>
                            </a>
                            <div class="mt-1">
                                <x-mini-stats-row :stats="$movie"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-neutral-800 rounded-xl p-10 text-center">
                    <p class="text-primary-400">No new releases available</p>
                </div>
            @endif
        </div>

        {{-- Recent Reviews - List Style --}}
        <div class="container mx-auto max-w-6xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold tracking-tight">Recent Reviews</h2>
                <a href="{{route('movies.new')}}"
                   class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 flex items-center gap-1 font-medium">
                    View all
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>

            @if (count($movies['latestReviews']) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($movies['latestReviews'] as $movie)
                        @if($latestReview = $movie->reviews->first())
                            <div class="flex flex-row pb-4 border-b border-b-neutral-600/50">
                                <div class="w-1/3">
                                    <a href="{{ route('movies.show', ['movie' => $movie]) }}"
                                    >
                                        <x-movie-card :movie="$movie"/>
                                    </a>
                                </div>
                                <!-- Content column -->
                                <div class="w-2/3 p-4 flex flex-col justify-between relative">
                                    <div>
                                        <h3 class="font-semibold text-sm truncate mb-1">{{ $movie->title }}</h3>

                                        <!-- Reviewed by -->
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">
                                            Reviewed by
                                            <x-underlined-link
                                                href="{{ route('users.profile', $latestReview->user->username) }}"
                                                class="hover:underline">{{ $latestReview->user->username }}</x-underlined-link>
                                        </p>
                                        <div class="mb-2 flex flex-row space-x-2 items-center">
                                            @if($latestReview->reelEntry->rating > 0)
                                                <x-star-rating-display :rating="$latestReview->reelEntry->rating"
                                                                       icon-size="w-4 h-4" icon-color="text-primary-400"
                                                                       icon-fill="fill-primary-400"/>
                                            @endif
                                            @if($latestReview->reelEntry->is_liked)
                                                <x-icon-heart-filled class="text-accent-500 w-4 h-4"/>
                                            @endif
                                        </div>


                                        <!-- Review content -->
                                        <p class="text-sm">
                                            {!! nl2br(e(Str::limit($latestReview->content, 300, preserveWords: true))) !!}
                                        </p>

                                        <!-- TODO: Link to the individual review -->
                                        <x-underlined-link
                                            href="{{ route('reviews.show', ['user' => $latestReview->user, 'movie' => $movie, 'review' => $latestReview]) }}"
                                            class="absolute bottom-0 right-4">Read more...
                                        </x-underlined-link>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center">
                    <p class="text-neutral-400">No reviews available yet</p>
                </div>
            @endif
        </div>
    </div>


</x-app>
