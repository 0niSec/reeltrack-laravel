<div>
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        {{ $attributes->merge(['value' => $value ?? null, 'placeholder' => $placeholder ?? null, 'autocomplete' =>
        $autocomplete ?? null, 'class' => 'border border-gray-500 text-gray-400 text-sm bg-gray-900 focus:bg-gray-800 focus:text-gray-300 rounded-md
        shadow-sm py-1.5 px-1.5
        w-full
        focus:outline-none
        focus:ring-primary-500 focus:border-primary-500']) }}
    />
</div>
