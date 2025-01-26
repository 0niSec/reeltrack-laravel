<x-app>
    <x-slot:title>{{ $title ?? 'Reeltrack' }}</x-slot:title>

    <div class="container max-w-5xl">
        <div class="grid grid-cols-4 mt-10">
            {{ $slot }}
        </div>
    </div>
</x-app>

