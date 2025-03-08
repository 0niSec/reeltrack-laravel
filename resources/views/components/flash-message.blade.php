@props(['type' => 'success', 'message'])

@if(session($type) && $message)
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="fixed top-4 right-4 max-w-sm bg-{{ $type === 'success' ? 'green' : 'red' }}-700 text-white
         rounded-md p-4 shadow-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($type === 'success')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                @endif
            </svg>
            <div class="alert">{{ $message }}</div>
        </div>
    </div>
@endif
