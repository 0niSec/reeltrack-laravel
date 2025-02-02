<x-registration-layout>
    <x-slot:title>Login</x-slot:title>

    <div class="flex items-center justify-center min-h-screen">
        <div
            class="p-6 border-2 border-zinc-700 rounded-lg shadow-xl bg-zinc-800 max-w-md w-full
            mx-auto">
            <h1 class="text-2xl text-primary-500 font-bold text-center" id="login-heading">Login</h1>

            <!-- Form Components -->
            <form action="/login" method="POST" class="flex flex-col space-y-3"
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
                    <x-form-label for="password" value="Password" class="mb-1">Password</x-form-label>
                    <x-form-input placeholder="Password" id="password" name="password" :value="old('password')"
                                  type="password" required
                                  aria-required="true"/>
                    <x-form-error name="password"/>
                </div>


                <x-form-submit-button>Login</x-form-submit-button>

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
                        <x-inline-link href="{{route('register')}}">Register</x-inline-link>
                    </p>
                    <a href="#" class="text-sm text-primary-500 hover:text-primary-400 transition-colors">Forgot your
                        password?</a>
                </div>

                <a class="text-sm rounded-md bg-zinc-600 hover:bg-zinc-500 transition-colors text-zinc-100 px-4 py-2"
                   href="{{route('index')}}"
                   type="button"
                   id="back-button">
                    Back
                </a>
            </div>

        </div>
    </div>
</x-registration-layout>
