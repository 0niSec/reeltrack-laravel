<div class="relative" data-controller="dropdown">
    {{-- Button --}}
    <button
        data-dropdown-target="button"
        data-action="dropdown#toggle"
        class="bg-transparent text-primary-500 text-sm p-1 pr-8
               border-primary-950 border rounded-md
               focus:outline-hidden focus:ring-0
               flex items-center"
    >
        <span>{{ $button_text }}</span>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-4 h-4 absolute right-2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5"
            />
        </svg>
    </button>

    {{-- Menu --}}
    <div
        data-dropdown-target="menu"
        class="absolute z-10 mt-1 hidden w-48
               bg-neutral-800 border border-neutral-700 rounded-md
               shadow-lg"
    >
        @foreach ($menu_items as $item)
            <a
                href="{{ $item['path'] }}"
                class="block px-4 py-2 text-sm text-primary-500
                       hover:bg-primary-900 hover:text-primary-300"
            >
                {{ $item['text'] }}
            </a>
        @endforeach
    </div>
</div>
