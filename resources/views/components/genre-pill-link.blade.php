@props([
    /** @var mixed */
    'genre'
])

<a
    href="{{ route('movies.index', ['genre' => $genre->name ?? 'genre-placeholder']) }}"
    {{ $attributes->class(['px-3 py-1 font-medium rounded-full border border-primary-500 text-sm
    hover:bg-primary-500 hover:text-white transition-colors']) }}
>
    {{ $genre->name }}
</a>
