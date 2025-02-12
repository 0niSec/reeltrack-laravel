<header class="bg-gradient-to-b from-zinc-950 to-zinc-900 border-b border-primary-600 shadow-2xl">
    <div class="container max-w-6xl">
        <div class="flex items-center justify-between h-16">
            {{-- Logo/Brand --}}
            <div class="shrink-0">
                <a href="{{ route('index') }}" class="hover:text-primary-500 text-2xl font-bold transition-colors">
                    <span class="text-primary-500">Reel</span>track
                </a>
            </div>


            {{-- Navigation --}}
            <nav class="flex items-center space-x-4">
                <a href="{{ route('movies.index') }}"
                   class="font-bold hover:text-primary-500 transition-colors relative group" wire:navigate.hover>
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

                {{-- Search --}}
                <livewire:search-input/>
            </nav>
        </div>
    </div>
</header>
