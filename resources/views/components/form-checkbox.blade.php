<div class="relative inline-block w-5 h-5">
    <input
        {{ $attributes->merge(['class' => 'peer absolute w-full h-full appearance-none
               border border-zinc-500 rounded-md shadow-sm
               focus:outline-none focus:ring-primary-500
               focus:border-primary-500 checked:bg-primary-800 cursor-pointer']) }}
        type="checkbox"
    />
    <!-- Icon is initially hidden. It becomes visible when checkbox is checked. -->
    <x-icon-check
        class="invisible pointer-events-none absolute inset-0 m-auto text-white
               w-4 h-4 peer-checked:visible"
    />
</div>
