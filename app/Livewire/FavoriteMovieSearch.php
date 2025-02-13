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
        $this->reset('searchResults');
//        $this->dispatch('close-modal');
    }

    public function updatedSearchText(string $value): void
    {
        $this->reset('searchResults');

        $this->validate();

        $wildcard = "%{$value}%";

        $this->searchResults = Movie::select(['id', 'title', 'release_date'])->with([
            'crew' => function ($query) {
                $query->where('job', 'Director');
            },
        ])->where('title', 'LIKE', $wildcard)->get();
    }

    public function render()
    {
        return view('livewire.favorite-movie-search');
    }
}
