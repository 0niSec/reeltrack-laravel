@php use App\Enums\CalloutType; @endphp
<x-app-about>
    <x-slot:title>FAQ</x-slot:title>

    {{-- Column 1 --}}
    @include('layouts.sidebar')

    {{-- Column 2 --}}
    <div class="col-span-3">
        <article class="leading-relaxed space-x-4">
            <h1 class="border-b border-b-primary-500">Creating Data</h1>

            <x-icon-tmdb class="w-40 h-40 float-left"/>
            <h2>Adding New Movies and Shows</h2>
            <p>All of the content data on Reeltrack is provided by
                <x-inline-link href="https://themoviedb.org">The Movie Database</x-inline-link>
                (TMDb) API. To add missing entries or correct inaccuracies for existing data, please use TMDb’s
                interface
                (you’ll need to create an account there too).
                {{-- TODO: We need a way to update incorrect records on our end too --}}
            </p>

            <p><em>Reeltrack uses the TMDb API but is not endorsed or certified by TMDb.</em></p>

            <h2>Import URL</h2>
            <p>There is a unique URL that a registered and logged-in user can access in their browser that will
                create a new piece of content on Reeltrack. This can be a movie or TV series. Depending on which type
                of item you want to add to Reeltrack, the URL will change.</p>

            <p>To import something new into Reeltrack, enter a URL in the following format into your browser:</p>

            <pre>https://reeltrack.com/tmdb/movie/{id}</pre>
            <pre>https://reeltrack.com/tmdb/tv/{id}</pre>

            {{-- TODO: Should we redirect just back to the TV Series home page or redirect to a progress page? --}}
            <x-callout :type="CalloutType::WARNING" class="mt-8 mb-8">Importing an entire series will take a long
                time. Every season, episode, cast and crew, and other metadata needs to be imported to keep the
                database up to date and accurate. When we detect that a series is being
                imported, we will redirect you to a page that will display the progress of the import.
            </x-callout>

            {{-- TODO: Fix spacing here --}}
            <x-callout :type="CalloutType::INFO" class="mt-8">You can get the ID by searching for your
                desired content on
                <x-inline-link href="https://themoviedb.org">TMDb</x-inline-link>
                . For example
                <pre>https://www.themoviedb.org/tv/<strong>94605</strong>-arcane/season/2</pre>
                where 94605 is the ID
                you would enter into the URL.
            </x-callout>

            <h2>Avoiding Duplicates</h2>
            <p>If I did my job correctly, it shouldn't be possible to import a duplicate into the application. If
                you spot something wrong with an entry, please use the report button on every individual item listing.
            </p>


        </article>
    </div>
</x-app-about>
