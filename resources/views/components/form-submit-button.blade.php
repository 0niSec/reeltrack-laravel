<button {{ $attributes->merge(['class' => 'rounded-md bg-primary-700 text-white font-medium shadow-lg inset-shadow-sm
hover:bg-primary-800
transition-colors ease-in-out px-4 py-2', 'type' => 'submit'])
}}>
    {{ $slot }}
</button>
