<!-- resources/views/components/feature-section.blade.php -->
@props(['imagePosition' => 'left', 'title', 'description', 'imageSrc', 'imageAlt' => ''])

<div class="py-12 md:py-16">
    <div class="container max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            @if ($imagePosition === 'left')
                <!-- Image column -->
                <div class="order-1 md:order-1">
                    <img src="{{ $imageSrc }}" alt="{{ $imageAlt }}"
                         class="w-full rounded-lg shadow-lg border border-neutral-500">
                </div>

                <!-- Content column -->
                <div class="order-2 md:order-2">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $title }}</h2>
                    <div class="text-neutral-300">
                        {{ $description }}
                    </div>

                    @if (isset($slot) && !empty(trim($slot)))
                        <div class="mt-4">
                            {{ $slot }}
                        </div>
                    @endif
                </div>
            @else
                <!-- Content column -->
                <div class="order-2 md:order-1">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $title }}</h2>
                    <div class="text-neutral-300">
                        {{ $description }}
                    </div>

                    @if (isset($slot) && !empty(trim($slot)))
                        <div class="mt-4">
                            {{ $slot }}
                        </div>
                    @endif
                </div>

                <!-- Image column -->
                <div class="order-1 md:order-2">
                    <img src="{{ $imageSrc }}" alt="{{ $imageAlt }}"
                         class="w-full rounded-lg shadow-lg border border-neutral-500">
                </div>
            @endif
        </div>
    </div>
</div>
