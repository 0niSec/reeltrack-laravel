<footer class="mt-24 border-t border-primary-700">
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-items-center">
            {{-- About Section --}}
            <div class="max-w-sm">
                <h3 class="text-lg font-bold mb-4">About Reeltrack</h3>
                <p class="text-neutral-400">
                    Track your favorite movies and TV shows, create watchlists,
                    and discover new content.
                </p>
                <x-nav-link href="{{ route('about.faq') }}" class="block mt-4 text-primary-500 hover:text-primary-400">
                    Read more...
                </x-nav-link>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <x-nav-link href="{{ url('/') }}">
                            Home
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ url('/about') }}">
                            About
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('movies.index') }}"
                        >
                            Movies
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="#">
                            TV Shows
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="#">
                            Lists
                        </x-nav-link>
                    </li>
                </ul>
            </div>

            {{-- Legal Links --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li>
                        <x-nav-link href="#">
                            Privacy Policy
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="#">
                            Terms of Service
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="#">
                            Contact Us
                        </x-nav-link>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-8 pt-8 border-t border-primary-700 text-center text-neutral-400">
            <p>
                &copy; {{ now()->year }} Reeltrack. All rights reserved.
            </p>
            <p>
                Powered by
                <x-nav-link href="https://www.themoviedb.org"
                >
                    The Movie Database
                </x-nav-link>
            </p>
            <p>
                Built with ❤️
                <x-nav-link href="https://laravel.com"
                >
                    Laravel
                </x-nav-link>
                and
                <x-nav-link href="https://tailwindcss.com"
                >
                    Tailwind CSS
                </x-nav-link>
            </p>
        </div>
    </div>
</footer>
