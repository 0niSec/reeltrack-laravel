<footer class="mt-24 border-t border-primary-800">
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-items-center">
            {{-- About Section --}}
            <div class="max-w-sm">
                <h3 class="text-lg font-bold mb-4">About Reeltrack</h3>
                <p class="text-neutral-400">
                    Track your favorite movies and TV shows, create watchlists,
                    and discover new content.
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/') }}" class="text-neutral-400 hover:text-primary-500 transition-colors">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/movies') }}"
                           class="text-neutral-400 hover:text-primary-500 transition-colors">
                            Movies
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-neutral-400 hover:text-primary-500 transition-colors">
                            TV Shows
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-neutral-400 hover:text-primary-500 transition-colors">
                            Lists
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Legal Links --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-neutral-400 hover:text-primary-500 transition-colors">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-neutral-400 hover:text-primary-500 transition-colors">
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-neutral-400 hover:text-primary-500 transition-colors">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-8 pt-8 border-t border-primary-800 text-center text-neutral-400">
            <p>
                &copy; {{ now()->year }} Reeltrack. All rights reserved.
            </p>
            <p>
                Powered by
                <a href="https://www.themoviedb.org" class="text-primary-500 hover:text-primary-600 transition-colors">
                    The Movie Database
                </a>
            </p>
            <p>
                Built with ❤️
                <a href="https://laravel.com" class="text-primary-500 hover:text-primary-600 transition-colors">
                    Laravel
                </a>
                and
                <a href="https://tailwindcss.com" class="text-primary-500 hover:text-primary-600 transition-colors">
                    Tailwind CSS
                </a>
            </p>
        </div>
    </div>
</footer>
