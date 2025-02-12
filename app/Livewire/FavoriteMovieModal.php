<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class FavoriteMovieModal extends Component
{
    public bool $isOpen = false;

    #[On('open-movie-modal')]
    public function openModal(): void
    {
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.favorite-movie-modal');
    }
}
