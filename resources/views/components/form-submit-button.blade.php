<button {{ $attributes->merge(['class' => 'rounded-md bg-primary-600 text-white hover:bg-primary-500
hover:text-zinc-800 transition-colors ease-in-out p-2', 'type' => 'submit'])
}} >
    {{ $slot }}
</button>
