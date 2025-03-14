<div>
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        {{ $attributes->merge(['value' => $value ?? null, 'placeholder' => $placeholder ?? null, 'autocomplete' =>
        $autocomplete ?? null, 'class' => 'border border-neutral-500 text-sm bg-neutral-900 placeholder:text-neutral-400/50 rounded-md
        shadow-sm py-1.5 px-1.5
        w-full
        focus:outline-none
        focus:ring-primary-500 focus:border-primary-500']) }}
    />
</div>
