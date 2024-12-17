@props(['areasName' => \App\Utils\AreaNameEnum::cases()])
<div x-data="{ areWithPassword: @entangle('areWithPassword') }" class="space-y-6">
    <div>
        <x-input-label for="operator_id" :value="__('Company')"/>
        <x-select-option
            wire:model="form.operator_id"
            :cases="$operatorOptions"
            id="operator_id"
            name="operator_id"
            type="text"
            class="mt-1 block w-full"
            autocomplete="operator_id" placeholder="Company"/>
        @error('form.operator_id')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" placeholder="Name"/>
        @error('form.name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input wire:model="form.email" id="email" name="email" type="text" class="mt-1 block w-full" autocomplete="email" placeholder="Email"/>
        @error('form.email')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="username" :value="__('Username')"/>
        <x-text-input wire:model="form.username" id="username" name="username" type="text" class="mt-1 block w-full" autocomplete="username" placeholder="Username"/>
        @error('form.username')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="role" :value="__('Role')"/>
        <x-select-option wire:model="form.role" :cases="\App\Utils\UserRoleEnum::cases()" id="role" name="role" type="text" class="mt-1 block w-full" autocomplete="role" placeholder="Role"/>
        @error('form.role')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    @can(\App\Policies\UserPolicy::IS_DEV_ROLE)
        <div>
            <x-input-label for="area_name" :value="__('Area')"/>
            <x-select-option wire:model="form.area_name" :cases="$areasName" id="area_name" name="area_name" type="text" class="mt-1 block w-full" autocomplete="area_name" placeholder="Area"/>
            @error('form.area_name')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
    @else
        <div>
            <x-input-label for="area_name" :value="__('Area')"/>
            <x-text-input disabled="disabled" wire:model="form.area_name" id="area_name" name="area_name" type="text" class="mt-1 block w-full" autocomplete="area_name" placeholder="Area"/>
            @error('form.area_name')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
    @endcan
    <div>
        @if($areWithPassword)
            <x-input-label for="password" :value="__('Password')"/>
        @else
            <x-input-label @click="areWithPassword = !areWithPassword" for="password" :value="__('Reset Password')" class="cursor-pointer font-bold text-green-800"/>
        @endif
        <x-text-input x-show="areWithPassword" wire:model="form.password" id="password" class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="password" placeholder="New Password"/>
        @error('form.password')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
