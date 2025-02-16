<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserSettingsAuth extends Component
{

    public string $username;
    public string $password;
    public string $email;

    public ?Carbon $usernameLastChangedAt = null;

    public function mount()
    {
        $this->usernameLastChangedAt = auth()->user()->username_last_changed_at ? Carbon::parse(auth()->user()
            ->username_last_changed_at) : null;
    }

    public function save()
    {
        // If nothing is filled out, flash an error
        if (empty($this->username) && empty($this->password) && empty($this->email)) {
            session()->flash('error', 'At least one field must be filled to update.');

            return;
        }

        $validated = $this->validate($this->rules());

        // Additional username checks only if username passed initial validation
        if (isset($validated['username'])) {
            if ($this->usernameLastChangedAt !== null
                && $this->usernameLastChangedAt->addDays(30) >= Carbon::now()) {
                session()->flash('error', 'You can only change your username once every 30 days.');

                return;
            }

            // FIXME: This may not be needed because the `unique` validation catches it
            if ($validated['username'] === auth()->user()->username) {
                session()->flash('error', 'Username must be different than your current username.');

                return;
            }
        }


        // Additional email check
        if (isset($validated['email']) && $validated['email'] === auth()->user()->email) {
            session()->flash('error', 'Email must be different than your current email.');

            return;
        }

        try {
            $updates = [];

            // Only include fields that have changed and are validated
            if (isset($validated['username'])) {
                $updates['username'] = $validated['username'];
                $updates['username_last_changed_at'] = now(); // Add timestamp when username changes
            }

            if (isset($validated['email'])) {
                $updates['email'] = $validated['email'];
            }

            if (isset($validated['password'])) {
                $updates['password'] = bcrypt($validated['password']);
            }

            if (empty($updates)) {
                session()->flash('info', 'No changes were made.');

                return;
            }

            // Update the user
            auth()->user()->update($updates);

            // Build success message
            $updatedFields = array_keys($updates);
            $userFacingFields = array_diff($updatedFields, ['username_last_changed_at']);
            session()->flash('success',
                'Successfully updated: '.implode(', ', array_map(Str::title(...), $userFacingFields)));

            // Regenerate session if username or password was changed
            if (isset($updates['username']) || isset($updates['password'])) {
                session()->regenerate();
            }
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        // Reset password field after attempt
        $this->password = '';
    }

    // Add custom messages if needed

    protected function rules(): array
    {
        return [
            'username' => [
                'nullable',
                'string',
                'between:3,20',
                'alpha_dash:ascii',
                'unique:users,username',
                function ($attribute, $value, $fail) {
                    $normalizedInput = strtolower($value);
                    $exists = User::whereRaw('LOWER(username) = ?', [$normalizedInput])->exists();
                    if ($exists) {
                        $fail('This username is already taken.');
                    }
                },
            ],
            'password' => [
                'nullable',
                Password::min(10)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(3),
            ],
            'email' => [
                'nullable',
                'email:rfc,dns,spoof',
                'unique:users,email',
            ],
        ];
    }

    #[Layout('components.settings-layout')]
    #[Title('Settings | Auth')]
    public function render()
    {
        return view('livewire.settings-auth', ['user' => auth()->user()]);
    }

    protected function messages()
    {
        return [
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
