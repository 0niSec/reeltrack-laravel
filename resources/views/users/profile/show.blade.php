<x-app>
    <x-slot:title>Profile</x-slot:title>

    <div class="container max-w-6xl mx-auto">
        <h1>Hello {{ $user->username }}</h1>

        <div class="mt-10 flex w-full justify-end">
            <form action="/profile">
                @csrf
                <button class="px-2 py-2 bg-primary-500 hover:bg-primary-400 transition-colors rounded-md">Edit
                    Profile
                </button>
            </form>
        </div>

    </div>
</x-app>
