<div>
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'border border-neutral-500 bg-neutral-800 focus:bg-neutral-800
        rounded-md
        shadow-sm py-1.5 px-1.5 text-sm
        w-full
        focus:outline-none
        focus:ring-primary-500 focus:border-primary-500']) }}
        placeholder="{{ $placeholder ?? '' }}"
    />
</div>
