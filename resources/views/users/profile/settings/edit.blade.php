<x-app>
    <x-slot:title>Account Settings</x-slot:title>
    <div class="container max-w-6xl mt-10">
        <h1 class="font-thin">Account Settings</h1>

        <div class="flex flex-col max-w-1/3 mt-8">
            <form action="/update" method="post" class="space-y-4 ">
                @csrf
                @method('PATCH')
                <h2 class="text-xl font-thin mb-4 text-primary-500">Profile</h2>
                <!-- Username -->
                <div>
                    <x-form-label for="username">Username</x-form-label>
                    <x-form-input-small type="text" name="username" value="{{  $user->username }}"/>
                </div>

                <!-- Nickname -->
                <div>
                    <x-form-label for="nickname">Nickname</x-form-label>
                    <x-form-input-small type="text" name="nickname" placeholder="John"/>
                </div>

                <!-- Email -->
                <div>
                    <x-form-label for="email">Email</x-form-label>
                    <x-form-input-small type="email" name="email" value="{{ $user->email }}"
                                        autocomplete="false"/>
                </div>

                <!-- Bio -->
                <div x-data="{ bioText: '' }">
                    <x-form-label for="bio">Bio</x-form-label>
                    <x-form-textarea name="bio" autocomplete="true" x-model="bioText"/>
                </div>

            </form>
        </div>
    </div>


</x-app>
