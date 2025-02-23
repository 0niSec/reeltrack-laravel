<div class="flex items-center gap-8">
    <label class="flex items-center text-sm gap-2">
        <input type="radio"
               name="watchedType"
               value="specific"
               wire:model="watchedType"
               class="peer appearance-none w-5 h-5 rounded-full border-2 border-gray-600
                          checked:border-primary-500 checked:border-[6px] bg-gray-700
                          transition-all duration-200 ease-in-out cursor-pointer"
               id="watched-date"/>

        <span>Watched on </span>
        <input type="date"
               class="bg-transparent border-none text-sm text-gray-200 focus:ring-0 cursor-pointer"
               name="watchedDate"
               wire:model="watchedDate"
               id="watched-date-picker"
               :disabled="watchedType !== 'specific'"/>
    </label>

    <label class="flex items-center text-sm gap-2">
        <input type="radio"
               name="watchedType"
               value="before"
               wire:model="watchedType"
               class="peer appearance-none w-5 h-5 rounded-full border-2 border-gray-600
                          checked:border-primary-500 checked:border-[6px] bg-gray-700
                          transition-all duration-200 ease-in-out cursor-pointer"
               id="watched-before"/>

        <span>I've watched this movie before</span>
    </label>
</div>
