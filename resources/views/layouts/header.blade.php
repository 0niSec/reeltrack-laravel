<header class="bg-gradient-to-b from-zinc-950/10 to-zinc-950 border-b border-primary-600 shadow-md">
    <div class="container max-w-6xl">
        <div class="flex items-center justify-between h-16">
            {{-- Logo/Brand --}}
            <div class="shrink-0">
                <a href="{{ route('index') }}" class="hover:text-primary-500 text-2xl font-bold transition-colors">
                    <span class="text-primary-500">Reel</span>track
                </a>
            </div>

            {{-- Search --}}
            <form action="{{ route('search') }}" method="GET" class="flex items-center">
                <div class="relative">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search"
                        class="border border-zinc-700 rounded-lg px-4 py-2 text-zinc-200 bg-zinc-800/50 backdrop-blur-sm
               focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    <button
                        type="submit"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 bg-transparent border-none cursor-pointer"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-zinc-200 hover:text-primary-500 transition-colors"
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
                <a href="{{ route('movies.index') }}"
                   class="font-bold hover:text-primary-500 transition-colors relative group">
                    Movies
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="{{ route('index') }}" class="font-bold hover:text-primary-500 transition-colors relative
                group">
                    TV
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="{{ url('/') }}" class="font-bold hover:text-primary-500 transition-colors relative group">
                    Lists
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all group-hover:w-full"></span>
                </a>

                @auth
                    {{-- Sign Out --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="font-bold hover:text-primary-500 transition-colors"
                        >
                            Logout
                        </button>
                    </form>

                    {{-- Profile with Avatar --}}
                    <a
                        href="{{ route('profile', ['user' => Auth::user()->username]) }}"
                        class="flex items-center space-x-2 hover:text-primary-500 transition-colors group"
                    >
                        <img
                            src="https://ui-avatars.com/api/?rounded=true"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-primary-500 transition-colors"
                        >
                        <span class="font-bold">
        {{ Auth::user()->username }}
    </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="font-bold hover:text-primary-500 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="font-bold hover:text-primary-500 transition-colors">
                        Register
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</header>
