<div data-controller="rating">
    <label class="block text-sm text-primary-400 mb-1">
        Rating
    </label>

    <input
        type="hidden"
        name="rating"
        value="0"
        data-rating-target="input"
    />

    <div class="relative flex items-center group">
        <!-- Clear rating button -->
        <div
            class="absolute right-full items-center flex opacity-0 transition-opacity duration-200 ease-out group-hover:opacity-100 pr-2">
            <button
                type="button"
                class="text-neutral-600 hover:text-primary-400 w-5 h-5"
                data-action="click->rating#clearRating"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="w-5 h-5"
                >
                    <path
                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                </svg>
            </button>
        </div>

        <div class="flex">
            @for ($i = 0; $i < 5; $i++)
                <div class="relative w-8 h-8">
                    <!-- Left half star -->
                    <div
                        class="cursor-pointer absolute inset-0 w-4 h-8"
                        data-rating-target="star"
                        data-value="{{ $i + 0.5 }}"
                        data-action="mouseenter->rating#mouseEnter mouseleave->rating#mouseLeave click->rating#setRating"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-8 h-8 text-neutral-600 transition-colors"
                            style="clip-path: inset(0 50% 0 0);"
                        >
                            <path
                                fill="currentColor"
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                            />
                        </svg>
                    </div>

                    <!-- Right half star -->
                    <div
                        class="cursor-pointer absolute inset-0 left-4 w-4 h-8"
                        data-rating-target="star"
                        data-value="{{ $i + 1.0 }}"
                        data-action="mouseenter->rating#mouseEnter mouseleave->rating#mouseLeave click->rating#setRating"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-8 h-8 text-neutral-600 transition-colors"
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
</div>
