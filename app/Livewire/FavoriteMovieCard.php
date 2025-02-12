<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\On;
use Livewire\Component;

class FavoriteMovieCard extends Component
{
    public ?Movie $selectedMovie = null;
    public $showModal = false;

    #[On('movie-selected')]
    public function setMovie($movie)
    {
        $this->selectedMovie = $movie;
        $this->showModal = false;
    }

    public function dispatchShowModal(): void
    {
        $this->dispatch('open-movie-modal')->to(FavoriteMovieModal::class);
    }


    public function render()
    {
        return view('livewire.favorite-movie-card');
    }
}
