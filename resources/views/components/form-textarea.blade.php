<div>
    <textarea
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'border border-zinc-500 text-zinc-400 bg-zinc-900 focus:bg-zinc-800
        focus:text-zinc-300 rounded-md
        shadow-sm py-1.5 px-1.5 text-sm
        w-full
        focus:outline-none
        focus:ring-primary-500 focus:border-primary-500']) }}
        rows="5"
        spellcheck="true"
    >{{ $slot }}</textarea>
</div>
