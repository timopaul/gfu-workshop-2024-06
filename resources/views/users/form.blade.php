<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($user))
                {{ __('Edit user ":user"', ['user' => $user->name]) }}
            @else
                {{ __('Create new user') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="post" action="{{ route(isset($user) ? 'users.update' : 'users.save') }}"
                      class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    @if (isset($user))
                        <input type="hidden" name="id" value="{{ $user->id }}"/>
                    @endif

                    <div>
                        <x-input-label for="name" :value="__('Name')"/>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      :value="old('name', $user->name ?? '')" required autofocus autocomplete="name"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                      :value="old('email', $user->email ?? '')" required autocomplete="username"/>
                        <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                    </div>

                    <div>
                        <x-input-label for="dob" :value="__('Date of birth')"/>
                        <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full"
                                      :value="old('dob', $user->dob ?? '')" autocomplete="dob"/>
                        <x-input-error class="mt-2" :messages="$errors->get('dob')"/>
                    </div>

                    <div>
                        <x-input-label for="driver_license" :value="__('Driver license')"/>
                        <x-text-input id="driver_license" name="driver_license" type="text" class="mt-1 block w-full"
                                      :value="old('driver_license', $user->driver_license ?? '')"
                                      autocomplete="driver_license"/>
                        <x-input-error class="mt-2" :messages="$errors->get('driver_license')"/>
                    </div>

                    @if ( ! isset($user))
                        <div>
                            <x-input-label for="password" :value="__('Password')"/>
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                          autocomplete="new-password"/>
                            <x-input-error class="mt-2" :messages="$errors->get('password')"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                          class="block mt-1 w-full" required autocomplete="new-password"/>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                        </div>
                    @endif

                    <div>
                        <x-input-label for="roles" :value="__('Roles')"/>
                        <x-input-error class="mt-2" :messages="$errors->get('roles')"/>
                        @foreach($roles as $role)
                            <input type="checkbox" name="roles[{{ $role->id }}]"
                                   value="{{ $role->id }}" {{ old('roles.' . $role->id) || (isset($user) && $user->hasRole($role)) ? 'checked="checked"'  : '' }}> {{ $role->name }}
                            <br/>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</x-app-layout>
