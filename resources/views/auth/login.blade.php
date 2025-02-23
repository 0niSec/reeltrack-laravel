<x-registration-layout>
    <x-slot:title>Login</x-slot:title>

    <div class="flex items-center justify-center min-h-screen">
        <div
            class="p-6 border-2 border-gray-700 rounded-lg shadow-xl shadow-gray-800/50 bg-gray-800 max-w-md w-full
            mx-auto">
            <div class="flex flex-col items-center justify-center mb-8 space-y-2">
                <h1
                    class="text-2xl text-gray-200 font-bold text-center"
                    id="login-heading">Log in to your
                    account</h1>
                <span class="block text-gray-400 text-sm">Enter your username and password below to log in</span>
            </div>

            <!-- Form Components -->
            <form action="/login" method="POST" class="flex flex-col space-y-6"
                  aria-labelledby="login-heading">
                @csrf

                <!-- Username -->
                <div>
                    <x-form-label for="username" value="Username"
                                  aria-for="username" class="mb-1">Username
                    </x-form-label>
                    <x-form-input placeholder="Username" id="username" name="username" :value="old('username')" required
                                  aria-required="true"/>
                    <x-form-error name="username"/>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex flex-row justify-between">
                        <x-form-label for="password" value="Password" class="mb-1">Password</x-form-label>
                        <a href="#" class="text-sm text-primary-500 hover:text-primary-400 underline underline-offset-2
                        transition-colors">Forgot
                            your
                            password?</a>
                    </div>
                    <x-form-input placeholder="Password" id="password" name="password" :value="old('password')"
                                  type="password" required
                                  aria-required="true"/>
                    <x-form-error name="password"/>
                </div>


                <x-form-submit-button>Log in</x-form-submit-button>

                <!-- Remember Me -->
                <div class="flex flex-row space-x-2 items-center">
                    <x-form-checkbox name="remember" id="remember"/>
                    <x-form-label for="remember" value="Remember Me" aria-for="remember">Remember
                        Me
                    </x-form-label>
                </div>

            </form>
            <div class="flex flex-row mt-10 items-center justify-between">
                <div class="flex flex-col space-y-1">
                    <p class="text-sm">Need an account?
                        <x-inline-link href="{{route('register')}}" class="underline
                        underline-offset-2">Register
                        </x-inline-link>
                    </p>

                </div>

                <a class="text-sm rounded-md bg-gray-600 hover:bg-gray-500 transition-colors text-gray-100 px-4 py-2"
                   href="{{route('index')}}"
                   type="button"
                   id="back-button">
                    Back
                </a>
            </div>

        </div>
    </div>
</x-registration-layout>
