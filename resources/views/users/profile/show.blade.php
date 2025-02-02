<x-app>
    <x-slot:title>{{ $user->username }}'s Profile</x-slot:title>

    <div class="container max-w-6xl mx-auto min-h-screen">

        <!-- Inner container -->
        <div class="flex justify-between items-center mt-10">
            <!-- Username, avatar, edit profile button -->
            <div class="flex items-center space-x-4">
                @if($user->profile->avatar)
                    <img src="{{ $user->profile->id }}" alt="Profile Photo" class="rounded-full h-20 w-20 object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&size=128"
                         alt="Default Avatar" class="rounded-full h-20 w-20 object-cover">
                @endif
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ $user->username }}
                    </h1>
                    <p class="text-sm text-zinc-500">Member since {{ $user->created_at->year }}</p>
                </div>
                @can('edit', $user->profile)
                    <a href="{{ route('profile.edit', ['user' => Auth::user()->username]) }}" class="flex items-center
            space-x-2 text-sm p-2 bg-zinc-700 rounded-lg shadow-xl inset-shadow-2xs font-bold hover:bg-zinc-600
            transition-all ease-in-out">Edit Profile</a>
                @endcan
            </div>

            <!-- User Stats -->
            <div id="user-stats" class="flex items-center space-x-4">
                <div class="flex items-center space-x-8">
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm text-zinc-500">Stat 1</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm text-zinc-500">Stat 2</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm text-zinc-500">Stat 3</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-medium">0</span>
                        <span class="block text-sm text-zinc-500">Stat 4</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
