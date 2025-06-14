<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $username = '';
    public string $operator_name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $authenticated = Auth::user();
        $this->name = $authenticated->name;
        $this->username = $authenticated->username;
        $this->operator_name = $authenticated->company->name
            ? trim($authenticated->company->prefix . ' ' .
                $authenticated->company->name . ' ' .
                $authenticated->company->postfix) : 'NA';
        $this->email = $authenticated->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile PostWoInfo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="operator_name" :value="__('Company')"/>
            <x-text-input wire:model="operator_name" disabled="disabled" id="operator_name"
                          operator_name="operator_name" type="text" class="mt-1 block w-full" required autofocus
                          autocomplete="operator_name"/>
            <x-input-error class="mt-2" :messages="$errors->get('operator_name')"/>
        </div>
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required
                          autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>
        <div>
            <x-input-label for="username" :value="__('Username')"/>
            <x-text-input wire:model="username" disabled="disabled" id="username" username="username" type="text"
                          class="mt-1 block w-full"
                          required autofocus autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('username')"/>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" disabled="disabled" id="email" name="email" type="email"
                          class="mt-1 block w-full" required
                          autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
