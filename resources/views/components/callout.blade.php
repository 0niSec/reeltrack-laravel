@php
    use App\Enums\CalloutType;

    // Pick an icon name from your configured Blade Icons set.
    $iconName = match ($type) {
        CalloutType::WARNING => 'icon-warning',
        CalloutType::ERROR => 'icon-error',
        default => 'icon-info',  // Fallback icon
    };
@endphp

@props(['type' => CalloutType::INFO])


<div {{ $attributes->merge([
    'class' => match ($type) {
        CalloutType::INFO => 'bg-blue-900/70 shadow-xs shadow-zinc-700 text-blue-200 border-blue-200',
        CalloutType::WARNING => 'bg-yellow-900/70 text-yellow-200 border-yellow-200',
        CalloutType::ERROR => 'bg-red-900/70 text-red-200 border-red-200',
    } . ' grid grid-cols-[auto,1fr] gap-2 items-center px-4 py-2 rounded border'
]) }}>
    <!-- Show the selected icon -->
    <x-dynamic-component :component="$iconName" class="inline-block mr-2 w-5 h-5"/>

    <!-- Your main callout content -->
    <div class="col-start-2">
        {{ $slot }}
    </div>
</div>
