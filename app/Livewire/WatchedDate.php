<?php

namespace App\Livewire;

use Livewire\Component;

class WatchedDate extends Component
{

    public ?string $watchedType = 'specific';
    public ?string $watchedDate = null;

    public function mount()
    {
        $this->watchedDate = now()->format('Y-m-d');
    }


    public function updatedWatchedType()
    {
        if ($this->watchedType !== 'specific') {
            $this->watchedDate = null;
        }
    }


    public function render()
    {
        return view('livewire.watched-date');
    }
}
