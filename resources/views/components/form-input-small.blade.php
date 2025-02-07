<div>
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        class="border border-zinc-500 text-zinc-400 text-sm bg-zinc-900 focus:bg-zinc-800 focus:text-zinc-300 rounded-md
        shadow-sm py-1.5 px-1.5
        w-full
        focus:outline-none
        focus:ring-primary-500 focus:border-primary-500"
        {{ $attributes->merge(['value' => $value ?? null, 'placeholder' => $placeholder ?? null, 'autocomplete' =>
        $autocomplete ?? null]) }}
    />
</div>
