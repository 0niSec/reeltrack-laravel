<div>
    <textarea
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'border border-gray-500 text-gray-400 bg-gray-900 focus:bg-gray-800
        focus:text-gray-300 rounded-md
        shadow-sm py-1.5 px-1.5 text-sm
        w-full
        focus:outline-none
        focus:ring-primary-500 focus:border-primary-500']) }}
        rows="5"
        spellcheck="true"
    >{{ $slot }}</textarea>
</div>
