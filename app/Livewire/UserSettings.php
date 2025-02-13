<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserSettings extends Component
{
    use WithFileUploads;

    public $nickname;
    public $bio;
    public $website;
    public $twitter;
    public $facebook;
    public $instagram;
    public $bluesky;
    public $youtube;
    public $tiktok;
    public $avatar;

    public function mount()
    {
        $user = auth()->user();
        $this->nickname = $user->nickname;
        $this->bio = $user->bio;
        $this->website = $user->website;
        $this->twitter = $user->twitter;
        $this->facebook = $user->facebook;
        $this->instagram = $user->instagram;
        $this->bluesky = $user->bluesky;
        $this->youtube = $user->youtube;
        $this->tiktok = $user->tiktok;
    }

    public function save()
    {
        $validated = $this->validate([
            'nickname' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:100'],
            'twitter' => ['nullable', 'string', 'max:30'],
            'facebook' => ['nullable', 'string', 'max:30'],
            'instagram' => ['nullable', 'string', 'max:30'],
            'bluesky' => ['nullable', 'string', 'max:30'],
            'youtube' => ['nullable', 'string', 'max:30'],
            'tiktok' => ['nullable', 'string', 'max:30'],
            'avatar' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ]);

        $user = auth()->user();

        if ($this->avatar) {
            $validated['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($validated);

        session()->flash('message', 'Settings updated successfully.');
    }

    #[Layout('components.settings-layout')]
    #[Title('Settings')]
    public function render(): View
    {
        return view('livewire.settings', [
            'user' => auth()->user(),
        ]);
    }
}
