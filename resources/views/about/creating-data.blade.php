<x-app-about>
    <x-slot:title>FAQ</x-slot:title>

    {{-- Column 1 --}}
    @include('layouts.sidebar')

    {{-- Column 2 --}}
    <div class="col-span-3">
        <article class="leading-relaxed">
            <h1 class="border-b pb-2 border-b-primary-500">Creating Data</h1>

            <h2>Adding New Movies and Shows</h2>
            <p>All of the content data on Reeltrack is provided by
                <x-inline-link href="https://themoviedb.org">The Movie Database</x-inline-link>
                (TMDb) API.
            </p>


        </article>
    </div>
</x-app-about>
