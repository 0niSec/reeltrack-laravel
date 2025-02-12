<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FavoriteMovieSearch extends Component
{
    #[Validate('required')]
    public string $searchText = '';
    public $searchResults = [];

    public function selectMovie(int $movieId): void
    {
        $this->dispatch('movie-selected', $movieId);
    }

    public function updatedSearchText(string $value): void
    {
        $this->reset('searchResults');

        $this->validate();

        $query = "%{$value}%";

        $this->searchResults = Movie::select(['id', 'title', 'release_date'])
            ->with('crew') // if you also want to access crew data
            ->where('title', 'LIKE', $query)
            ->limit(15)
            ->get();
    }

    public function render()
    {
        return view('livewire.favorite-movie-search');
    }
}
