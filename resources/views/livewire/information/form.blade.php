<div class="space-y-6">
    <div>
        <x-input-label for="operator" :value="__('Operator')"/>
        <x-text-input wire:model="form.operator" id="operator" name="operator" type="text" class="mt-1 block w-full" autocomplete="operator" placeholder="Operator"/>
        @error('form.operator')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="vehicle_type" :value="__('Vehicle Type')"/>
        <x-text-input wire:model="form.vehicle_type" id="vehicle_type" name="vehicle_type" type="text" class="mt-1 block w-full" autocomplete="vehicle_type" placeholder="Vehicle Type"/>
        @error('form.vehicle_type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="police_number" :value="__('Police Number')"/>
        <x-text-input wire:model="form.police_number" id="police_number" name="police_number" type="text" class="mt-1 block w-full" autocomplete="police_number" placeholder="Police Number"/>
        @error('form.police_number')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="driver_name" :value="__('Driver Name')"/>
        <x-text-input wire:model="form.driver_name" id="driver_name" name="driver_name" type="text" class="mt-1 block w-full" autocomplete="driver_name" placeholder="Driver Name"/>
        @error('form.driver_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="start_plan" :value="__('Start Plan')"/>
        <x-text-input id="start_plan" name="start_plan" type="datetime-local" class="mt-1 block w-full" autocomplete="start_plan" placeholder="Start Plan" wire:model="form.start_plan" min="{{date('Y-m-d')}}T{{date('hh:mm:ss')}}"/>  {{--wire:keydown.tab="onAddLoadTimePressed"--}}
        @error('form.start_plan')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="end_plan" :value="__('End Plan')"/>
        <x-text-input id="end_plan" name="end_plan" type="datetime-local" class="mt-1 block w-full" autocomplete="end_plan" placeholder="End Plan" wire:model="form.end_plan" min="{{date('Y-m-d')}}T{{date('hh:mm:ss')}}"/>
        @error('form.end_plan')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="shift" :value="__('Shift')"/>
        <x-text-input wire:model="form.shift" id="shift" name="shift" type="text" class="mt-1 block w-full" autocomplete="shift" placeholder="Shift"/>
        @error('form.shift')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="area" :value="__('Area')"/>
        <x-text-input wire:model="form.area" id="area" name="area" type="text" class="mt-1 block w-full" autocomplete="area" placeholder="Area"/>
        @error('form.area')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    {{--<div>
        <x-input-label for="post_id" :value="__('Post Id')"/>
        <x-text-input wire:model="form.post_id" id="post_id" name="post_id" type="text" class="mt-1 block w-full" autocomplete="post_id" placeholder="Post Id"/>
    </div>--}}

    <div class="flex items-center gap-4">
        @error('form.post_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        <x-primary-button disabled="{{$disabled}}" {{--wire:click="form.setVehicleType"--}}>Submit</x-primary-button>
    </div>
    {{--<div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>--}}
</div>
