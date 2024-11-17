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
    @if(!empty($form->operator_id))
        <div>
            <x-input-label for="vehicle_id" :value="__('Vehicle Number')"/>
            <x-select-option
                id="vehicle_id" name="vehicle_id"
                wire:model="form.vehicle_id"
                wire:change="onVehicleChange"
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
        <x-input-label for="vehicle_type" :value="__('Vehicle Type')"/>
        <x-text-input
            wire:model="form.vehicle_type" disabled="true" id="vehicle_type" name="vehicle_type" type="text" class="mt-1 block w-full" placeholder="Vehicle Type"/>
        @error('form.vehicle_type')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
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
        <div id="shift" class="flex flex-wrap ms-2 space-x-6">
            <div class="flex items-center">
                <input wire:model="form.shift" id="shift" name="shift" type="radio" value="{{\App\Utils\InformationShiftEnum::DAY->value}}" class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focusring-yellow-500 dark:focusring-yellow-600 dark:ring-offset-gray-800 focusring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{\App\Utils\InformationShiftEnum::DAY->value}}</label>
            </div>
            <div class="flex items-center">
                <input wire:model="form.shift" id="shift" name="shift" type="radio" value="{{\App\Utils\InformationShiftEnum::NIGHT->value}}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focusring-green-500 dark:focusring-green-600 dark:ring-offset-gray-800 focusring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="green-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{\App\Utils\InformationShiftEnum::NIGHT->value}}</label>
            </div>
        </div>
        @error('form.shift')
        <x-input-error class="mt-2" messages="message"/>
        @enderror
    </div>
   {{-- <div>
        <x-input-label for="shift" :value="__('Shift')"/>
        <x-select-option wire:model="form.shift" id="shift" name="shift"
                         :cases="\App\Utils\InformationShiftEnum::cases()"/>
        @error('form.shift')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>--}}
    <div>
        <x-input-label for="area" :value="__('Area')"/>
        <x-text-input wire:model="form.area" disabled="true" id="area" name="area" />
        {{--<x-select-option wire:model="form.area" id="area" name="area" :cases="\App\Utils\AreaNameEnum::cases()"/>--}}
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
