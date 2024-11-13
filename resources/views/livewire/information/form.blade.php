@props(['disabled' => false])

<div class="space-y-6">
    <div>
        <x-input-label for="operator_id" :value="__('Operator')"/>
        <x-select-option
                id="operator_id" name="operator_id"
                wire:model="form.operator_id"
                wire:change="onOperatorIdChange"
                :cases="$operators"/>

        @error('form.operator')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="vehicle_type" :value="__('Vehicle Type')"/>
        <x-select-option wire:model="form.vehicle_type" id="vehicle_type" name="vehicle_type"
                         :cases="\App\Utils\VehicleClassEnum::cases()"/>
        @error('form.vehicle_type')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    @if(!empty($form->operator_id))
        <div>
            <x-input-label for="vehicle_id" :value="__('Vehicle Number')"/>
            <x-select-option
                    id="vehicle_id" name="vehicle_id"
                    wire:model="form.vehicle_id"
                    :cases="$vehicles"/>
        </div>
        <div>
            <x-input-label for="crew_id" :value="__('Driver Name')"/>
            <x-select-option
                    id="crew_id" name="crew_id"
                    wire:model="form.crew_id"
                    :cases="$crews"/>
            @error('form.crew_id')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
    @endif
    <div>
        <x-input-label for="start_plan" :value="__('Start Plan')"/>
        <x-text-input id="start_plan" name="start_plan" type="datetime-local" class="mt-1 block w-full"
                      autocomplete="start_plan" placeholder="Start Plan" wire:model="form.start_plan"
                      min="{{date('Y-m-d')}}T{{date('hh:mm:ss')}}"/> {{--wire:keydown.tab="onAddLoadTimePressed"--}}
        @error('form.start_plan')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="end_plan" :value="__('End Plan')"/>
        <x-text-input id="end_plan" name="end_plan" type="datetime-local" class="mt-1 block w-full"
                      autocomplete="end_plan" placeholder="End Plan" wire:model="form.end_plan"
                      min="{{date('Y-m-d')}}T{{date('hh:mm:ss')}}"/>
        @error('form.end_plan')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="shift" :value="__('Shift')"/>
        <x-select-option wire:model="form.shift" id="shift" name="shift"
                         :cases="\App\Utils\InformationShiftEnum::cases()"/>
        @error('form.shift')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="area" :value="__('Area')"/>
        <x-select-option wire:model="form.area" id="area" name="area" :cases="\App\Utils\InformationAreaEnum::cases()"/>
        @error('form.area')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        @error('form.vehicle_id')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        @error('form.post_id')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        <x-primary-button>Submit</x-primary-button>
    </div>
    {{--<div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>--}}
</div>
