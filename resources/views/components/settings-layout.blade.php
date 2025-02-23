<x-app>
    <x-slot:title>Settings</x-slot:title>
    <div class="container max-w-6xl mt-10">
        <h1 class="font-thin">{{ $heading }}</h1>

        {{-- Settings Navigation --}}
        <div class="mt-8">
            <nav class="flex flex-row items-center space-x-4 p-4 bg-gray-900 rounded-md">
                <ul class="flex space-x-4">
                    <li class="text-gray-400">
                        <a href="{{ route('settings.profile') }}"
                           class="{{ request()->routeIs('settings.profile') ?
                        'underline underline-primary-500 underline-offset-8 text-primary-500' : 'text-gray-400
                        hover:text-primary-500' }}" wire:navigate.hover>Profile</a>
                    </li>
                    <li class="text-gray-400">
                        <a href="{{ route('settings.auth') }}" class="{{ request()->routeIs('settings.auth') ?
                        'underline underline-primary-500 underline-offset-8 text-primary-500' : 'text-gray-400
                        hover:text-primary-500' }}"
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
