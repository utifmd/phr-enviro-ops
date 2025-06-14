<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

/*
 * TODO:
 * 1. email verification after registration
 * */

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $company_id = '';
    public string $role = \App\Utils\UserRoleEnum::GUEST_ROLE->value;
    public string $area_name = \App\Utils\AreaNameEnum::AllArea->value;
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        \Illuminate\Support\Facades\Log::debug('Register');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'username' => ['string', 'lowercase', 'username'],
            'area_name' => ['required', 'string'],
            'company_id' => ['string'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);
        \Illuminate\Support\Facades\Log::debug(json_encode($validated));

        try {

            $validated['username'] = explode("@", $validated['email'])[0] ?? $validated['email'];
            $validated['area_name'] = \App\Utils\AreaNameEnum::HO->value;
            $validated['role'] = \App\Utils\UserRoleEnum::GUEST_ROLE->value;
            $validated['company_id'] = "ab85c933-e0ae-404a-9467-205c4d2b7a7c"; // explode("@", $validated['email'])[0] ?? $validated['email'];
            $validated['password'] = Hash::make($validated['password']);

            event(new Registered($user = User::create($validated)));
            Auth::login($user);

            \Illuminate\Support\Facades\Log::debug('Register do');
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::debug('Register else' . $e->getMessage());
            $this->addError('error', $e->getMessage());
        }

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                          placeholder="Full name"
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                          placeholder="Email"
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                          type="password"
                          name="password" placeholder="New Password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password" placeholder="Retype Password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div>
            <x-input-error :messages="$errors->get('username')" class="mt-2"/>
            <x-input-error :messages="$errors->get('role')" class="mt-2"/>
            <x-input-error :messages="$errors->get('area_name')" class="mt-2"/>
            <x-input-error :messages="$errors->get('company_id')" class="mt-2"/>
            @error('error')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
