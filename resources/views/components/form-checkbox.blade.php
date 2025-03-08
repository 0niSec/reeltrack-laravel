<div {{ $attributes->class(['cursor-pointer rounded-md mt-2 ']) }}>
    <label class="flex items-center text-sm gap-2">
        <div class="relative flex items-center">
            <input type="checkbox"
                   {{ $attributes->merge(['class' => 'peer appearance-none w-5 h-5 rounded border-2 border-gray-600
                   checked:bg-primary-500 checked:border-primary-500
                   hover:border-primary-400 focus:ring-2 focus:ring-primary-500/20
            bg-gray-700 transition-all duration-200 ease-in-out cursor-pointer"
            id="contains-spoilers']) }}
                   name="{{ $name }}"
                {{ old('$name') ? 'checked' : '' }}/>

            <svg
                class="absolute w-5 h-5 pointer-events-none text-white peer-checked:block hidden"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div class="flex items-center gap-2">
            <span class="cursor-pointer">{{ $slot }}</span>
        </div>
    </label>
</div>
