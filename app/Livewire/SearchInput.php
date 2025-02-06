<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SearchInput extends Component
{
    #[Validate('required')]
    public string $searchText = '';
    public $searchResults = [];

    public function updatedSearchText(string $value): void
    {
        $this->reset('searchResults');

        $this->validate();

        $query = "%{$value}%";

        $this->searchResults = Cache::remember("search-{$query}", now()->addHours(24), function () use ($query) {
            Log::info("Cache miss for query: {$query}");
            Log::info("Searching for {$query}");

            return Movie::where('title', 'LIKE', $query)->limit(15)->get();
        });
    }

    public function render()
    {
        return view('livewire.search-input');
    }
}
