<button
    type="button"
    x-on:click="$wire.showModal = true"

    {{ $attributes->class(['w-full bg-primary-800 py-2 rounded-md hover:bg-primary-600
                    transition-colors']) }}
>
    {{ $slot }}
</button>
