<x-app-about>
    <x-slot:title>FAQ</x-slot:title>

    {{-- Column 1 --}}
    @include('layouts.sidebar')

    {{-- Column 2 --}}
    <div class="col-span-3">
        <article class="prose">
            <h1 class="border-b pb-2 border-b-primary-500">About Reeltrack</h1>

            <h2 class="mt-4">What is Reeltrack?</h2>
            <p class="mt-2">Reeltrack is a personal project of mine that started as a way to learn
                <x-inline-link
                    href="https://php.net">PHP
                </x-inline-link>
                and
                <x-inline-link
                    href="https://laravel.com">Laravel
                </x-inline-link>
                . A coworker of mine had been asking me for a long time if I could make a website that would allow him
                to
                track both movies and TV shows since at the time of making this, there wasn't one.
            </p>
        </article>
    </div>
</x-app-about>
