<x-app>
    <x-slot:title>Settings</x-slot:title>
    <div class="container max-w-6xl mt-10">
        <h1 class="font-thin">Settings</h1>

        {{-- Settings Navigation --}}
        <div class="mt-8">
            <nav class="flex flex-row items-center space-x-4 p-4 bg-zinc-800 rounded-md">
                <ul class="flex space-x-4">
                    <li class="text-zinc-500">
                        <a href="{{ route('settings.profile') }}"
                           class="hover:text-primary-600 border-b" wire:navigate.hover>Profile</a>
                    </li>
                    <li class="text-zinc-500">
                        <a href="{{ route('settings.auth') }}" class="hover:text-primary-600 border-b"
                           wire:navigate.hover>Auth</a>
                    </li>
                    {{-- TODO: Other items here --}}
                </ul>
            </nav>
        </div>

        {{-- Main Content --}}
        {{ $slot }}
    </div>
</x-app>
