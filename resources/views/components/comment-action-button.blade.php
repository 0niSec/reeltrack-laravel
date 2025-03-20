@props([
    'comment' => null,
    'review' => null,
    'movie' => null
])

<div {{ $attributes->class(['relative text-sm']) }} x-data="{ isOpen: false, showEditor: false }">
    <button role="button"
            class="px-4 py-2 w-fit bg-surface-200 cursor-pointer border border-transparent hover:bg-surface-100 hover:border-accent-500 transition-colors"
            @click="isOpen = !isOpen">
        ...
    </button>

    <div class="font-medium absolute top-full right-0 shadow-lg z-50"
         @click="isOpen = ! isOpen"
         x-show="isOpen"
         @click.away="isOpen = false"
         x-transition x-cloak>
        <div class="mt-2 bg-surface-200 py-1 min-w-[160px]">
            <button class="w-full text-left px-2 py-1 hover:bg-surface-100"
                    @click="showEditor = !showEditor">
                Reply
            </button>

            @auth
                @if($comment)
                    @if(auth()->id() === $comment->user_id)
                        <button form="delete-comment-form"
                                wire:confirm.prompt="Are you sure?"
                                class="w-full text-left px-2 py-1 hover:bg-surface-100">
                            Delete
                        </button>
                    @endif
                @elseif($review)
                    @if(auth()->id() === $review->user_id)
                        <button form="delete-review-form"
                                wire:confirm.prompt="Are you sure?"
                                class="w-full text-left px-2 py-1 hover:bg-surface-100">
                            Delete
                        </button>
                    @endif
                @endif
            @endauth
        </div>
    </div>

    @if($comment)
        <x-reply-editor :parent="$comment"/>
        <form id="delete-comment-form"
              action="{{ route('comments.destroy', ['user' => $comment->user, 'review' => $comment->review, 'comment' => $comment]) }}"
              method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @elseif($review)
        <x-reply-editor :parent="$review"/>
        <form id="delete-review-form"
              action="{{ route('reviews.destroy', ['user' => $review->user, 'movie' => $movie, 'review' => $review]) }}"
              method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>
