<div class="flex flex-col gap-4">
    {{-- Exact Date Option --}}
    <label class="flex items-center text-sm gap-2 cursor-pointer">
        <div class="relative flex items-center">
            <input type="radio"
                   name="date_type"
                   value="specific_date"
                   class="peer appearance-none w-5 h-5 rounded-full border-2 border-gray-600
                          checked:bg-primary-500 checked:border-primary-500
                          hover:border-primary-400 focus:ring-2 focus:ring-primary-500/20
                          bg-gray-700 transition-all duration-200 ease-in-out cursor-pointer"
                   checked
                   id="date-type-specific-date"/>
            <svg class="absolute w-4 h-4 pointer-events-none text-white peer-checked:block hidden left-0.5"
                 viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="6" fill="currentColor"/>
            </svg>
        </div>
        <div class="flex items-center gap-2">
            <span>I watched this on</span>
            <input type="date"
                   class="bg-transparent border-none text-sm text-gray-200 focus:ring-0 cursor-pointer"
                   name="watch_date"
                   value="{{  now()->format('Y-m-d') }}"
                   max="{{ date('Y-m-d') }}"
                   id="watched-date-picker"/>
        </div>
    </label>

    {{-- Don't Remember Option --}}
    <label class="flex items-center text-sm gap-2 cursor-pointer">
        <div class="relative flex items-center">
            <input type="radio"
                   name="date_type"
                   value="unknown"
                   class="peer appearance-none w-5 h-5 rounded-full border-2 border-gray-600
                          checked:bg-primary-500 checked:border-primary-500
                          hover:border-primary-400 focus:ring-2 focus:ring-primary-500/20
                          bg-gray-700 transition-all duration-200 ease-in-out cursor-pointer"
                   id="date-type-unknown"/>
            <svg class="absolute w-4 h-4 pointer-events-none text-white peer-checked:block hidden left-0.5"
                 viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="6" fill="currentColor"/>
            </svg>
        </div>
        <span>I don't remember when I watched this</span>
    </label>

    {{-- Specific Year Option --}}
    <label class="flex items-center text-sm gap-2 cursor-pointer">
        <div class="relative flex items-center">
            <input type="radio"
                   name="date_type"
                   value="estimated_year"
                   class="peer appearance-none w-5 h-5 rounded-full border-2 border-gray-600
                          checked:bg-primary-500 checked:border-primary-500
                          hover:border-primary-400 focus:ring-2 focus:ring-primary-500/20
                          bg-gray-700 transition-all duration-200 ease-in-out cursor-pointer"
                   id="date-type-specific"/>
            <svg class="absolute w-4 h-4 pointer-events-none text-white peer-checked:block hidden left-0.5"
                 viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="6" fill="currentColor"/>
            </svg>
        </div>
        <div class="flex items-center gap-2">
            <span>I watched this sometime in</span>
            <select name="estimated_year"
                    class="bg-gray-700 px-2 py-1 border-gray-600 text-sm rounded-md focus:ring-primary-500
                    focus:border-primary-500 cursor-pointer">
                @for($y = date('Y'); $y >= 1920; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </label>

    {{-- Rewatch Option --}}
    <label class="flex items-center text-sm gap-2 mt-2 cursor-pointer" for="is_rewatch">
        <div class="relative flex items-center">
            <input type="checkbox"
                   name="is_rewatch"
                   :checked="{{old('is_rewatch', false)}}"
                   class="peer appearance-none w-5 h-5 rounded border-2 border-gray-600
                          checked:bg-primary-500 checked:border-primary-500
                          hover:border-primary-400 focus:ring-2 focus:ring-primary-500/20
                          bg-gray-700 transition-all duration-200 ease-in-out cursor-pointer"
                   id="watched-before"/>
            <svg class="absolute w-5 h-5 pointer-events-none text-white peer-checked:block hidden"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div class="flex items-center gap-2">
            <span>This is a rewatch</span>
            <span class="text-gray-400 text-xs">(I've seen this movie before)</span>
        </div>
    </label>
</div>
