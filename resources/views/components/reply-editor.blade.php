@php use App\Models\Review; @endphp
@props(['parent'])

<template x-teleport="body">
    <div x-show="showEditor"
         class="fixed bottom-0 bg-surface/50 container mx-auto max-w-2xl flex flex-col items-center backdrop-blur-xl px-6 py-4 left-0 right-0 shadow-lg"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-y-full"
         x-transition:enter-end="transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="transform translate-y-0"
         x-transition:leave-end="transform translate-y-full"
         x-cloak
         @click.away="showEditor = false"
         @keydown.escape.window="showEditor = false">

        <div class="container mx-auto flex flex-col space-y-2">
            <p class="text-sm">Reply to <span class="text-primary-500">{{ $parent->user->username }}</span></p>


            <form
                action="{{ route('comments.store', ['user' => $parent->user,'review' => $parent instanceof Review ? $parent : $parent->review]) }}"
                method="POST">
                @csrf

                @unless($parent instanceof Review)
                    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                @endunless

                <textarea
                    name="content"
                    class="w-full pt-2 text-sm focus:outline-none focus:border-primary-500 resize-none"
                    rows="7"
                    placeholder="Write your reply..."
                >{{ old('content') }}</textarea>

                <x-form-error name="content"/>

                <div class="mt-3 flex justify-end space-x-4 font-medium">
                    <button type="button"
                            class="px-10 py-2 min-w-40 text-sm bg-neutral-600 hover:bg-neutral-800 transition-colors"
                            @click="showEditor = false">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-10 py-2 text-sm min-w-40 bg-primary-500 hover:bg-primary-600 transition-colors">
                        Post
                    </button>
                </div>
            </form>
        </div>
</template>
