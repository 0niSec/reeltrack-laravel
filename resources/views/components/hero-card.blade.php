@props(['title' => null])

<div {{ $attributes->class(['bg-primary-700/30 p-6 rounded-lg backdrop-blur-sm border border-primary-700']) }}>
    <div class="text-primary-400 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
    <p class="text-zinc-300">{{ $slot }}</p>
</div>
