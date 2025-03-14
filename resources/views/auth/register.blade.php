<x-registration-layout>
    <x-slot:title>Register</x-slot:title>

    <div class="flex items-center justify-center min-h-screen">
        <div
            class="p-6 border-2 border-neutral-700 rounded-lg shadow-lg bg-neutral-900 max-w-md w-full mx-auto">
            <h1 class="text-2xl text-primary-500 font-bold text-center" id="register-heading">Register</h1>
            <p class="text-sm text-center text-neutral-300 mb-10">We're looking forward to having you!</p>

            <!-- Form Components -->
            <form action="/register" method="POST" class="flex flex-col space-y-4"
                  aria-labelledby="register-heading">
                @csrf

                <!-- Username -->
                <div>
                    <x-form-label for="username" value="Username" aria-for="username"
                                  class="mb-1">Username
                    </x-form-label>
                    <x-form-input placeholder="ILoveMovies99" id="username" name="username" required
                                  aria-required="true"/>
                    <x-form-error name="username"/>
                </div>

                <!-- Email -->
                <div>
                    <x-form-label for="email" value="Email">Email</x-form-label>
                    <x-form-input placeholder="your.email@example.com" id="email" name="email" required
                                  aria-required="true" class="mb-1"
                                  type="email"/>
                    <x-form-error name="email"/>
                </div>

                <!-- Password -->
                <div>
                    <x-form-label for="password" value="Password" class="mb-1">Password</x-form-label>
                    <x-form-input placeholder="M0v13s4r3Aw3s0m3!" id="password" name="password" type="password" required
                                  aria-required="true"/>
                    <x-form-error name="password"/>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <x-form-label for="password_confirmation" value="Confirm Password" class="mb-1">Confirm
                        Password
                    </x-form-label>
                    <x-form-input placeholder="Confirm your password" id="password_confirmation"
                                  name="password_confirmation" type="password" required
                                  aria-required="true"/>
                    <x-form-error name="password_confirmation"/>
                </div>

                <x-form-submit-button>Register</x-form-submit-button>
            </form>
            <div class="flex flex-row mt-10 items-center justify-between">
                <p class="text-sm">Need to make an account?
                    <x-underlined-link href="{{ route('login') }}">Log in</x-underlined-link>
                </p>

                <a class="text-sm rounded-md bg-neutral-600 text-neutral-100 px-4 py-2" href="{{route('home')}}"
                   type="button"
                   id="back-button">
                    Back
                </a>
            </div>

        </div>
    </div>
</x-registration-layout>
