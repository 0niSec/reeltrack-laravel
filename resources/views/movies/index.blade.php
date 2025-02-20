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

    {{-- Flash Message Container --}}
    @if(session('status'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)" {{-- 4-second auto-dismiss --}}
            x-show="show"
            x-transition
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-800 text-white p-4 rounded shadow-md
           flex items-center justify-between gap-2 max-w-md z-50"
            style="display: none;" {{-- ensures Alpine’s x-show binding works cleanly --}}
        >
            <span class="mr-2">{{ session('status') }}</span>
            <button
                type="button"
                class="font-bold px-2 hover:text-black"
                @click="show = false"
            >
                &times;
            </button>
        </div>
    @endif

    @if(session('error'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)" {{-- 4-second auto-dismiss --}}
            x-show="show"
            x-transition
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-800 text-white p-4 rounded shadow-md
           flex items-center justify-between gap-2 max-w-md z-50"
            style="display: none;" {{-- ensures Alpine’s x-show binding works cleanly --}}
        >
            <span class="mr-2">{{ session('error') }}</span>
            <button
                type="button"
                class="font-bold px-2 hover:text-black"
                @click="show = false"
            >
                <x-icon-close class="w-4 h-4"/>
            </button>
        </div>
    @endif

    @if(session('warning'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)" {{-- 4-second auto-dismiss --}}
            x-show="show"
            x-transition
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-yellow-800 text-white p-4 rounded shadow-md
           flex items-center justify-between gap-2 max-w-md z-50"
            style="display: none;" {{-- ensures Alpine’s x-show binding works cleanly --}}
        >
            <span class="mr-2">{{ session('warning') }}</span>
            <button
                type="button"
                class="font-bold px-2 hover:text-black"
                @click="show = false"
            >
                &times;
            </button>
        </div>

    @endif


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
    <div class="flex flex-col space-y-20">
        <div class="container max-w-6xl">
            <x-display-heading href="{{route('movies.popular')}}" :heading="'What\'s popular?'"/>

            {{-- Movies --}}
            @if (count($movies['popular']) > 0)
                <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-x-4 gap-y-4">
                    @foreach ($movies['popular'] as $movie)
                        <div class="flex flex-col">
                            <a href="{{ route('movies.show', $movie) }}" class="hover:opacity-75
                            transition-opacity">
                                <x-movie-card :movie="$movie"/>
                            </a>
                            <x-mini-stats-row class="mt-1" :stats="$movie"/>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center w-full">
                    <p class="text-lg text-primary-400">No movies have been added yet!</p>
                </div>
            @endif
        </div>

        {{-- New --}}
        <div class="container max-w-6xl">
            <x-display-heading href="{{route('movies.new')}}" :heading="'What\'s new this week?'"/>


            @if (count($movies['newest']) > 0)
                <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-x-4 gap-y-4">
                    @foreach ($movies['newest'] as $movie)
                        <div class="flex flex-col">
                            <a href="{{ route('movies.show', $movie) }}"
                               class="hover:opacity-75 transition-opacity" wire:navigate>
                                <x-movie-card :movie="$movie"/>
                            </a>
                            <x-mini-stats-row class="mt-1" :stats="$movie"/>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center w-full">
                    <p class="text-lg text-primary-400">No movies have been added yet!</p>
                </div>
            @endif
        </div>

        {{-- Latest Reviews --}}
        {{-- TODO: This should actually link to the review of the movie that a user created --}}
        <div class="container max-w-6xl">
            <x-display-heading href="{{route('movies.new')}}" :heading="'Recent Reviews'"/>


            @if (count($movies['latestReviews']) > 0)
                <div class="movies-grid grid grid-cols-[repeat(auto-fill,minmax(120px,1fr))] gap-x-4 gap-y-4">
                    @foreach ($movies['latestReviews'] as $movie)
                        <div class="flex flex-col">
                            <a href="{{ url('/movies/' . $movie->id) }}"
                               class="hover:opacity-75 transition-opacity">
                                <x-movie-card :movie="$movie"/>
                            </a>
                            <x-mini-stats-row class="mt-1" :stats="$movie"/>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center w-full">
                    <p class="text-lg text-primary-400">No movies have been added yet!</p>
                </div>
            @endif
        </div>
    </div>


</x-app>
