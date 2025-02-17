<div>
    <x-slot:heading>Auth Settings</x-slot:heading>

    @if(session('success'))
        <div
            class="absolute bg-green-800 rounded-md p-4 w-auto max-w-md h-auto max-h-32 top-25 left-1/2
            transform
            -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center" x-data="{ showSuccess: true }"
            x-show="showSuccess"
            x-init="setTimeout(() => showSuccess = false, 5000)">
            <div class="alert flex items-center">
                <x-icon-check-circle class="w-8 h-8 mr-4"/> {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div
            class="absolute bg-red-800 rounded-md p-4 w-auto max-w-md h-auto max-h-32 top-25 left-1/2
            transform
            -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center" x-data="{ showError: true }"
            x-show="showError"
            x-init="setTimeout(() => showError = false, 5000)">
            <div class="alert flex items-center">
                <x-icon-error-circle class="w-8 h-8 mr-4"/> {{ session('error') }}
            </div>
        </div>
    @endif

    <form wire:submit="save" class="mt-10">
        <!-- Username -->
        <div class="w-1/2 flex flex-col space-y-6">
            <div>
                <p class="mb-4 text-sm">Change your username. Your username must be alphanumeric (dashes and underscores
                    are
                    okay) and
                    between 3 and 20 characters. You are allowed to update your username every thirty days, at most.</p>
                <div class="flex items-center justify-between space-x-2">
                    <x-form-label for="username">Username</x-form-label>
                    @if($username)
                        <p class="{{ $isUsernameAvailable ? 'text-green-500' : 'text-red-500' }} text-sm flex items-center">
                            @if($isUsernameAvailable)
                                <x-icon-check-circle class="w-4 h-4 inline-block mr-1"/>
                            @else
                                <x-icon-x-mark class="w-4 h-4 inline-block mr-1"/>
                            @endif
                            {{ $usernameMessage }}
                        </p>
                    @endif
                </div>
                <x-form-input-small type="text" wire:model.live.debounce.300ms="username" name="username"/>
                <x-form-error name="username"/>
            </div>

            <!-- Password -->
            <div>
                <x-form-label for="password">Password</x-form-label>
                <div class="flex items-center" x-data="{ passwordVisible: false }">
                    <div class="relative">
                        <div class="relative flex items-center">
                            <x-form-input-small wire:model="password"
                                                name="password"
                                                type="password"
                                                class="flex-grow"/>
                            <button type="button"
                                    class="absolute right-0 top-1/2 -translate-y-1/2 pr-2 text-gray-500"
                                    @click="passwordVisible = !passwordVisible"
                                    onclick="togglePasswordVisibility()">
                                <template x-if="!passwordVisible">
                                    <x-icon-eye-slash class="h-5 w-5 hover:text-zinc-400"/>
                                </template>
                                <template x-if="passwordVisible">
                                    <x-icon-eye-outline class="h-5 w-5 hover:text-zinc-400"/>
                                </template>
                            </button>
                        </div>
                        <div class="mt-1">
                            <x-form-error name="password"/>
                        </div>
                    </div>
                </div>

                <script>
                    function togglePasswordVisibility() {
                        const input = document.querySelector('input[name="password"]');
                        if (input.type === 'password') {
                            input.type = 'text';
                        } else {
                            input.type = 'password';
                        }
                    }
                </script>
            </div>

            <!-- Email -->
            <div>
                <p class="mb-4 text-sm">Associate a new email address with your account. We will send you a
                    confirmation email to the new address. You <strong>must</strong> click this link to finalize the
                    change.
                </p>
                <!-- TODO: Email confirmation -->
                <x-form-label for="email">Email</x-form-label>
                <x-form-input-small type="text" wire:model="email" name="email"
                                    :value="old('email')"/>
                <x-form-error name="email"/>
            </div>
        </div>
        <x-form-submit-button class="mt-8">Save</x-form-submit-button>
    </form>
</div>
