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
        }
    }"
>
    <label class="block text-sm text-primary-400 mb-1">
        {{ $rating > 0 ? 'Rated' : 'Rating' }}
    </label>

    <!-- Hidden input allows the final rating to be sent on form submission -->
    <input
        type="hidden"
        name="rating"
        :value="livewireRating"
    />

    <!-- 5 stars, each split into half increments -->
    <div class="flex" x-cloak>
        @for($i = 0; $i < 5; $i++)
            <div class="relative w-8 h-8">
                <!-- Left half-star -->
                <div
                    class="cursor-pointer absolute inset-0 w-4 h-8"
                    @mouseover="setHover({{ $i + 0.5 }})"
                    @mouseleave="clearHover()"
                    @click="$wire.setRating({{ $i + 0.5 }}); livewireRating = {{ $i + 0.5 }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="w-8 h-8 transition-colors"
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
                    class="cursor-pointer absolute inset-0 left-4 w-4 h-8"
                    @mouseover="setHover({{ $i + 1.0 }})"
                    @mouseleave="clearHover()"
                    @click="$wire.setRating({{ $i + 1.0 }}); livewireRating = {{ $i + 1.0 }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="w-8 h-8 transition-colors"
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
