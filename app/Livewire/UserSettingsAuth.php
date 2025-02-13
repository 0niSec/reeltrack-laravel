<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserSettingsAuth extends Component
{
    #[Layout('components.settings-layout')]
    #[Title('Settings | Auth')]
    public function render()
    {
        return view('livewire.settings-auth');
    }
}
