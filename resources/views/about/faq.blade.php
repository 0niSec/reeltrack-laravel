@php use App\Enums\CalloutType; @endphp
<x-app-about>
    <x-slot:title>FAQ</x-slot:title>

    {{-- Column 1 --}}
    @include('layouts.sidebar')

    {{-- Column 2 --}}
    <div class="col-span-3">
        <article class="leading-relaxed">
            {{-- About --}}
            <h1 class="border-b border-b-primary-500">About</h1>

            <h2>What is Reeltrack?</h2>
            <p>Reeltrack is a personal project of mine that started as a way to learn
                <x-inline-link
                    href="https://php.net">PHP
                </x-inline-link>
                and
                <x-inline-link
                    href="https://laravel.com">Laravel
                </x-inline-link>
                . A coworker of mine had been asking me for a long time if I could make a website that would allow him
                to track both movies and TV shows since at the time of making this, there wasn't one.
                <x-inline-link href="https://letterboxd.com">Letterboxd</x-inline-link>
                is what he said he uses for movies, but he said it'd be cool if he could do both all on one site. And
                thus, this project was born.
            </p>

            <h2>Are there ads?</h2>
            <p>No! There will not be any ads on this site as long as I can help it. There may be a plan in the future to
                sign up for KoFi or Patreon to help me keep the lights on, but I will not place any ads on the site.</p>

            {{-- Membership --}}
            <h1 class="border-b border-b-primary-500">Membership</h1>

            <h2>Do I need an account?</h2>
            <p>No, you do not need an account to view any of the content on this site. All content provided is offered
                free of charge and without requiring an account. However, certain features will be disabled without an
                account. For a full list of things reserved for users with an account, see below.</p>

            <ul class="list-disc list-inside mt-8 mb-8">
                <li>Rating, reviewing and liking content</li>
                <li>Creating lists</li>
                <li>Adding new content. For more information on this, see
                    <x-inline-link
                        href="{{ route('about.creating-data') }}">here
                    </x-inline-link>
                </li>
                <li>Interacting with other users</li>
                <li>Adding content to watchlists</li>
            </ul>

            <h2>How do I sign up?</h2>
            <p>You can
                <x-inline-link href="{{ route('register') }}">create an account</x-inline-link>
                and get started right away. We only need an email from you.
            </p>

            <h2>Are there different member tiers?</h2>
            <p>No, once you sign up, you have access to everything above and there's nothing beyond that.</p>

            <h2>Does it cost anything?</h2>
            <p>No! For the time being, this service is free. There are no paywalls, premium services, VIP treatment --
                none of that. With that being said, I will do my best to keep this free for
                as long as possible. The only thing being considered while developing this is to maybe get a KoFi or
                Patreon or something so people can help me pay for server
                costs, but that would be the only thing I am considering for the time being.</p>

            {{-- Features --}}
            <h1 class="border-b border-b-primary-500">General</h1>

            <h2>How do I use the site?</h2>
            <p>However you like! This is meant to be a place to keep track of things you've watched, things you want to
                see and things you're watching. We encourage people to read through the
                <x-inline-link href="{{ route('welcome') }}">Welcome</x-inline-link>
                page to get acquainted with all that you can do on the site.
            </p>

            <p>The easiest way to get started is to just go browse our
                <x-inline-link href="{{ route('movies.index') }}">movies</x-inline-link>
                and
                <x-inline-link href="{{ route('series.index') }}">TV</x-inline-link>
                pages. From here, you can hover over each poster image (displays the poster overlay) and use the "eye"
                icon to mark something you've
                seen. You can also mark something as "liked" or add it to a list from the poster overlay. Anything you
                mark as "watched" will be added to your profile, allowing others to see what you've watched. You can
                configure whether or not you want to see your watched items on any page here on Reeltrack.
            </p>

            <p>From each individual page for a movie or tv series/season/episode, you can interact with the different
                actions here too. Click the "Leave a Review" button to open a modal that will let you enter the body of
                your review. Optionally, in this modal, while reviewing the movie, you can also set when you watched the
                content, and leave a rating or if you liked it. Reviews you've left will be displayed on that item's
                page for others to see. Recent reviews, ratings and likes will also be displayed on your profile.</p>

            <h2>What does marking a TV series or season as "watching" do?</h2>
            <p>Setting a TV series or season to the "watching" status does a few things. It:</p>

            <ul class="list-disc list-inside mt-8 mb-8 space-y-2">
                <li>Adds the series to a "Now Watching" list. Marking a season as "watching" will mark the series as
                    "watching". When marking a series as "watching" with no season marked, you will be prompted to
                    select the season that you
                    are currently watching and Reeltrack will mark it for you. Your "Now Watching" list will then be
                    generated and display the series and season you are watching.
                </li>
                <li>Curates an "Up Next" list based on the oldest unwatched episode in your currently "watching" season.
                    For example, if you have <i><i>Arcane</i>
                        Season 2</i> marked as "watching", and you have episodes 1, 2 and 3 in that season marked as
                    "watched", <i><i>Arcane</i>
                        Season 2 - Episode 4</i> would show up in this list for this series. Even if you do not have
                    Season 1 watched, we do not make any assumptions on the order you are watching the seasons in. We
                    aren't here to judge.
                </li>
            </ul>

            <x-callout :type="CalloutType::INFO">The "watching" status is an evolving idea.
                Tracking TV
                shows is hard as
                I've come to find out.
            </x-callout>

            <h2>What does marking something as "watched" do?</h2>
            {{-- Marking movies as watched --}}
            <p>You can mark a movie as watched by clicking the eye icon when hovering
                over any movie/series poster image, or when writing a full review. Rating a movie will also mark as
                watched. Marking a movie as watched adds it to your "watched" list and tells Reeltrack that you've seen
                the movie at some point in the past (you can set the date if you remember). Similar to Letterboxd,
                marking a film as "watched" adds to your overall total of movies watched, and is useful when browsing
                lists</p>

            {{-- Marking series/seasons/episodes as watched --}}
            <p>Marking a TV series, season and single episode as watched have varying differences.</p>

            <ul class="list-disc list-inside mt-8 mb-8 space-y-2">
                <li>Marking a series as watched marks every season and episode in the season(s) as watched.</li>
                <li>Marking a season as watched marks that season and every episode in that season as watched.</li>
                <li>Marking an episode as watched marks only that episode as watched.</li>
            </ul>

            <p>I believe doing it this way makes the most sense since it's assumed if you say to someone "I've seen
                Season 2 of <i>Arcane</i>" that you've seen every episode of that season. However, because a lot of TV
                seasons
                can be watched independently of the other seasons (you don't need prior knowledge of events in those
                seasons), we do not assume that you've seen the prior seasons if you mark a higher numbered season as
                watched.</p>

            <h2>A movie/series/season/episode isn't on here, what do I do?</h2>
            <p>Great question. It's answered
                <x-inline-link href="{{ route('about.creating-data') }}">here</x-inline-link>
                .
            </p>

            <h1 class="border-b border-b-primary-500">Technical</h1>

            <h2>Why Laravel and PHP?</h2>
            <p>Why not? I develop and program as a hobby, and after using <em>so</em> many Javascript frameworks (Nuxt,
                Next, Svelte, Astro), I was
                tired of trying to find all the right packages or libraries that would do everything I wanted and learn
                the way they wanted me to do things. I was constantly worried that I'd find something that maybe was
                lesser known or not as actively developed and having to then find something else down the road when it
                stopped being maintained.</p>

            <p>I know you can make that same argument for Laravel, but you really don't need
                to go hunting for any other packages. Everything you need is included out of the box. It's very much a
                "batteries included" framework. After having played with the MVC architecture and learning it, I really
                enjoy it.</p>

            <h2>I found something wrong with the site!</h2>
            <p>Whoops. Sorry about that. You can email {{-- TODO: add email --}} and let me know. At this time, I
                haven't decided if I will make the repo public on Github because I've never developed in a team
                before.</p>

            <h1 class="border-b border-b-primary-500">Legal</h1>

            <h2>Do you have legal documents I can read?</h2>
            <p>Yes.</p>

            {{-- TODO: Add these in as we create them --}}
            <ul class="list-disc list-inside mt-8 mb-8 space-y-2">
                <li>
                    <x-inline-link href="#">Privacy Policy</x-inline-link>
                </li>
                <li>
                    <x-inline-link href="#">Terms of Service</x-inline-link>
                </li>
            </ul>

        </article>
    </div>
</x-app-about>
