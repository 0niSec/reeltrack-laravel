<?php

namespace App\Livewire;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserSettings extends Component
{
    use WithFileUploads;

    public ?string $nickname;
    public ?string $bio;
    public ?string $website;
    public ?string $twitter;
    public ?string $facebook;
    public ?string $instagram;
    public ?string $bluesky;
    public ?string $youtube;
    public ?string $tiktok;
    public $avatar;

    public function mount()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $this->nickname = $user->profile->nickname;
        $this->bio = $user->profile->bio;
        $this->website = $user->profile->website;
        $this->twitter = $user->profile->twitter;
        $this->facebook = $user->profile->facebook;
        $this->instagram = $user->profile->instagram;
        $this->bluesky = $user->profile->bluesky;
        $this->youtube = $user->profile->youtube;
        $this->tiktok = $user->profile->tiktok;
    }

    public function save()
    {
        try {
            $validated = $this->validate([
                'nickname' => ['nullable', 'string', 'max:30'],
                'bio' => ['nullable', 'string', 'max:1000'],
                'website' => ['nullable', 'url', 'max:50'],
                'twitter' => ['nullable', 'string', 'max:15'],
                'facebook' => ['nullable', 'string', 'max:30'],
                'instagram' => ['nullable', 'string', 'max:30'],
                'bluesky' => ['nullable', 'string', 'max:35'],
                'youtube' => ['nullable', 'string', 'max:30'],
                'tiktok' => ['nullable', 'string', 'max:30'],
                'avatar' => ['nullable', 'image', 'max:1024'], // 1MB Max
            ]);

            $user = auth()->user();

            if (!$user) {
                session()->flash('error', 'User not found.');

                return;
            }

            $profile = $user->profile;

            if (!$profile) {
                session()->flash('error', 'User profile not found.');

                return;
            }

            if ($this->avatar) {
                try {
                    // Delete old avatar if it exists
                    if ($profile->avatar) {
                        Storage::disk('public')->delete($profile->avatar);
                    }

                    $validated['avatar'] = $this->avatar->store('avatars', 'public');
                } catch (Exception $e) {
                    Log::error('Error uploading avatar: '.$e->getMessage());
                    session()->flash('error', 'Failed to upload avatar. Other settings were saved.');
                    unset($validated['avatar']); // Remove avatar from validated data if upload failed
                }
            } else {
                // Remove avatar from the $validated array if it is not set
                // We do not want to delete a user's avatar when they don't submit anything
                unset($validated['avatar']);
            }

            $profile->update($validated);
            session()->flash('success', 'Settings updated successfully.');
        } catch (Exception $e) {
            Log::error('Error saving user settings: '.$e->getMessage());
            session()->flash('error', 'Unable to save settings. Please try again.');
        }
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
