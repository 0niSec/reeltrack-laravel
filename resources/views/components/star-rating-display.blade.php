@props(['rating', 'iconSize' => 'w-5 h-5', 'iconColor' => 'text-primary-400', 'iconFill' => 'fill-primary-400'])

@php
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
@endphp

<span {{ $attributes->merge(['class' => 'flex items-center']) }}>
    @for ($i = 1; $i <= $fullStars; $i++)
        <x-icon-star class="{{ $iconSize }} {{ $iconColor }} {{ $iconFill }}"/>
    @endfor

    @if($hasHalfStar)
        <span class="mx-0.5">½</span>
    @endif
</span>
