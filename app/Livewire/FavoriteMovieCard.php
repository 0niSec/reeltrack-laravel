<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\On;
use Livewire\Component;

class FavoriteMovieCard extends Component
{
    public int $movieId;
    public Movie $selectedMovie;

    #[On('movie-selected')]
    public function setMovie(int $movieId): void
    {
        $this->movieId = $movieId;
        $movie = Movie::findOrFail($movieId);

        $this->selectedMovie = $movie;
    }

    public function render()
    {
        return view('livewire.favorite-movie-card');
    }
}
