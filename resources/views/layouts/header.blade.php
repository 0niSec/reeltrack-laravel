<header class="border-b border-primary-600 shadow-md bg-neutral-900">
    <div class="container max-w-7xl">
        <div class="flex items-center justify-between h-16">
            {{-- Logo/Brand --}}
            <div class="flex-shrink-0">
                <h1 class="text-neutral-200 font-bold text-xl">
                    <a href="{{ url('/') }}" class="hover:text-primary-500 transition-colors">
                        Reeltrack
                    </a>
                </h1>
            </div>

            {{-- Search --}}
            <form action="{{ route('search') }}" method="GET" class="flex items-center">
                <div class="relative">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search"
                        class="border border-neutral-700 rounded-md px-2 py-1 text-neutral-200 bg-neutral-800
                               focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    <button
                        type="submit"
                        class="absolute inset-y-0 right-0 flex items-center pr-2 bg-transparent border-none cursor-pointer"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-neutral-200"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5
                                   0 1 0 5.196 5.196a7.5 7.5
                                   0 0 0 10.607 10.607Z"
                            />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Navigation --}}
            <nav class="flex items-center space-x-4">
                <a href="{{ url('/movies') }}" class="font-bold hover:text-primary-500 transition-colors">
                    Movies
                </a>
                <a href="#" class="font-bold hover:text-primary-500 transition-colors">
                    Shows
                </a>
                <a href="#" class="font-bold hover:text-primary-500 transition-colors">
                    Lists
                </a>

                @auth
                    {{-- Sign Out --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="font-bold hover:text-primary-500 transition-colors"
                        >
                            Sign Out
                        </button>
                    </form>

                    {{-- Profile with Avatar --}}
                    <a
                        href="{{ route('profile', ['user_id' => Auth::user()->id]) }}"
                        class="flex items-center space-x-2 hover:text-primary-500 transition-colors"
                    >
                        <img
                            src="https://ui-avatars.com/api/?rounded=true"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full"
                        >
                        <span class="font-bold">
                            <!-- TODO: Add this later -->
                            {{-- Auth::user()->username --}}
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="font-bold hover:text-primary-500 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="font-bold hover:text-primary-500 transition-colors">
                        Create Account
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</header>
