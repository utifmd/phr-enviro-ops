<div class="space-y-6">

    <div>
        <x-input-label for="plat" :value="__('Plat')"/>
        <x-text-input wire:model="form.plat" id="plat" name="plat" type="text" class="mt-1 block w-full"
                      autocomplete="plat" placeholder="Plat"/>
        @error('form.plat')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="type" :value="__('Type')"/>
        <x-select-option wire:model="form.type" :cases="\App\Utils\PostWoInfoVehicleTypeEnum::cases()" id="type"
                         name="type"/>
        @error('form.type')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="vendor" :value="__('Vendor')"/>
        <x-text-input wire:model="form.vendor" id="vendor" name="vendor" type="text" class="mt-1 block w-full"
                      autocomplete="vendor" placeholder="Vendor"/>
        @error('form.vendor')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror

        @error('form.operator_id')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    {{--<div>
        <x-input-label for="operator_id" :value="__('Operator Id')"/>
        <x-text-input wire:model="form.operator_id" id="operator_id" name="operator_id" type="text" class="mt-1 block w-full" autocomplete="operator_id" placeholder="Operator Id"/>
        @error('form.operator_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>--}}

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
