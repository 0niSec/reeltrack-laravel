@props(['type' => null, 'message' => null])

@if (session()->has('success') || session()->has('error') || session()->has('info') || session()->has('warning') || $message)
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
        @class([
            'fixed bottom-10 right-4 max-w-sm text-white rounded-md p-4 shadow-lg z-50',
            'bg-green-700' => session()->has('success') || $type === 'success',
            'bg-red-700' => session()->has('error') || $type === 'error',
            'bg-blue-700' => session()->has('info') || $type === 'info',
            'bg-yellow-700' => session()->has('warning') || $type === 'warning',
        ])>
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if (session()->has('success') || $type === 'success')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                @elseif (session()->has('error') || $type === 'error')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                @elseif (session()->has('info') || $type === 'info')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                @endif
            </svg>
            <div class="alert">
                {{ session('success') ?? session('error') ?? session('info') ?? session('warning') ?? $message }}
            </div>
        </div>
    </div>
@endif
