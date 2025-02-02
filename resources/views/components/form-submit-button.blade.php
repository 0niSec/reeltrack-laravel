<button {{ $attributes->merge(['class' => 'rounded-md bg-primary-600 text-white font-bold shadow-lg inset-shadow-sm
hover:bg-primary-700
transition-colors ease-in-out p-2', 'type' => 'submit'])
}} >
    {{ $slot }}
</button>
