@php use Carbon\Carbon; @endphp
<div class="review-item border rounded-lg p-4 shadow">
    <h3 class="review-title text-lg font-semibold mb-2">{{ $title }}</h3>
    <div class="review-rating text-yellow-500 text-sm mb-2">
        Rating: {{ $rating }} / 5
    </div>
    <div class="review-date text-gray-500 text-xs">
        Reviewed on: {{ Carbon::parse($date)->toFormattedDateString() }}
    </div>
</div>
