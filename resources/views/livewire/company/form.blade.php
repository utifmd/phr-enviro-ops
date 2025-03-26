<div class="space-y-6">
    <div class="flex gap-1">
        <div class="w-2/12">
            <x-input-label for="prefix" :value="__('Prefix')"/>
            <x-text-input wire:model="form.prefix" id="prefix" name="prefix" type="text" class="mt-1 block w-full" autocomplete="prefix" placeholder="e.g PT"/>
        </div>
        <div class="w-10/12">
            <x-input-label for="name" :value="__('Operator Name')"/>
            <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" placeholder="Name"/>
            @error('form.name')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
            @error('form.prefix')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
            @error('form.postfix')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div class="w-2/12">
            <x-input-label for="postfix" :value="__('Postfix')"/>
            <x-text-input wire:model="form.postfix" id="postfix" name="postfix" type="text" class="mt-1 block w-full" autocomplete="postfix" placeholder="e.g Tbk"/>
        </div>
    </div>
    <div>
        <x-input-label for="short_name" :value="__('Short Name')"/>
        <x-text-input wire:model="form.short_name" id="short_name" name="short_name" type="text" class="mt-1 block w-full" autocomplete="short_name" placeholder="Short Name"/>
        @error('form.short_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="department_id" :value="__('Teams')"/>
        <x-select-option wire:model="form.department_id" :cases="$departments" id="department_id" name="department_id"/>
        @error('form.department_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
