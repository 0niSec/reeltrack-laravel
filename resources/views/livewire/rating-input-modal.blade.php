<div
    x-data="{
        livewireRating: @entangle('rating'),
        hoverRating: 0,
        setHover(value) {
            this.hoverRating = value;
        },
        clearHover() {
            this.hoverRating = 0;
        },
        currentValue(halfStar) {
            // If hoverRating is non-zero, use it to show highlight preview
            return this.hoverRating > 0 ? this.hoverRating : this.livewireRating;
        },
        clearRating() {
            this.livewireRating = 0;
            $wire.clearRating();
        },
        showCloseIcon() {
            return this.livewireRating > 0 && (this.hoverRating > 0 || this.hoveringCloseIcon);
        },
        hoveringCloseIcon: false
    }"
>
    <label class="block text-sm text-primary-400 mb-1">
        {{ $rating > 0 ? 'Rated' : 'Rating' }}
    </label>

    <!-- 5 stars, each split into half increments -->
    <div class="flex relative items-center" x-cloak>
        <!-- Clear icon -->
        <div
            class="absolute -left-8 flex items-center justify-center w-8 h-8 rounded-full cursor-pointer transition-opacity"
            x-show="showCloseIcon()"
            @click="clearRating"
            x-data="{ visible: false }"
            @mouseover="hoveringCloseIcon = true"
            @mouseleave="hoveringCloseIcon = false; visible = false"
            x-transition
            :class="{ 'opacity-100': hoverRating > 0 || hoveringCloseIcon, 'opacity-50': !(hoverRating > 0 || hoveringCloseIcon) }"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-500" viewBox="0 0 24 24"
                 fill="currentColor">
                <path
                    d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"
                />
            </svg>
        </div>


        @for($i = 0; $i < 5; $i++)
            {{-- The width and height affects this component being in line with the rest --}}
            <div class="relative w-8 h-10">
                <input type="hidden" name="rating" :value="livewireRating" x-ref="ratingInput" wire:model="rating"/>
                <!-- Left half-star -->
                <div
                    class="cursor-pointer absolute inset-0 w-1 h-1"
                    @mouseover="setHover({{ $i + 0.5 }})"
                    @mouseleave="clearHover()"
                    @click="$wire.setRating({{ $i + 0.5 }}); livewireRating = {{ $i + 0.5 }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="w-10 h-10 transition-colors"
                        :class="(currentValue() >= {{ $i + 0.5 }})
                            ? 'text-yellow-500'
                            : 'text-zinc-600'"
                        style="clip-path: inset(0 50% 0 0);"
                    >
                        <path
                            fill="currentColor"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                        />
                    </svg>
                </div>

                <!-- Right half-star -->
                <div
                    class="cursor-pointer absolute inset-0 left-4 w-1 h-1"
                    @mouseover="setHover({{ $i + 1.0 }})"
                    @mouseleave="clearHover()"
                    @click="$wire.setRating({{ $i + 1.0 }}); livewireRating = {{ $i + 1.0 }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="w-10 h-10 transition-colors"
                        :class="(currentValue() >= {{ $i + 1.0 }})
                            ? 'text-yellow-500'
                            : 'text-zinc-600'"
                        style="clip-path: inset(0 0 0 50%); margin-left: -16px;"
                    >
                        <path
                            fill="currentColor"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                        />
                    </svg>
                </div>
            </div>
        @endfor
    </div>
</div>
