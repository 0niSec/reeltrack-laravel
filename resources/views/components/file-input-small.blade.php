<div class="flex items-center space-x-4">
    <input type="file" name="{{ $name }}" {{ $attributes->merge(['class' => 'text-sm rounded-md text-zinc-300 border
    border-zinc-500 p-1.5 cursor-pointer file:cursor-pointer file:pr-4 file:hover:text-zinc-500']) }} accept="{{ $accept }}">
</div>
