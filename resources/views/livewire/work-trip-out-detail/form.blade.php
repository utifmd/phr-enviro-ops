@props([
    'drilling' => \App\Utils\WorkTripDetailTypeEnum::DRILLING->value,
    'mudPit' => \App\Utils\WorkTripDetailTypeEnum::MUD_PIT->value,
    'concentratedWater' => \App\Utils\WorkTripDetailTypeEnum::CONCENTRATED_WATER->value,
    'treatedWater' => \App\Utils\WorkTripDetailTypeEnum::TREATED_WATER->value,
])
<div x-data="{
 formState:{
    isDrilling: true,

    wells: @entangle('wells'),
    vehicles: @entangle('vehicles'),

    wellsCollected: [],
    vehCollected: [],

    well: @entangle('form.well_name'),
    vehicle: @entangle('form.police_number'),
    rigName: @entangle('form.rig_name'),
    wbsNumber: @entangle('form.wbs_number')
 }
}" class="space-y-6">
    <div>
        <x-input-label for="time_in">
            Time In ({{$currentDate}})<span class="text-red-500">&nbsp*</span>
        </x-input-label>
        <x-select-option class="mt-1 block w-full" wire:model="form.time_in" wire:change.prevent="onTimeOptionChange"
                         :cases="$timeOptions" :isIdle="false" id="time_in" name="time_in"/>
        @error('form.time_in')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <x-loading-field label="Transporter" for="transporter" required="true">
        <x-select-option
            id="transporter" name="transporter" type="text" class="mt-1 block w-full" autocomplete="transporter" placeholder="Transporter"
            wire:model="operatorId"
            wire:change="onOperatorOptionChange"
            x-on:change="formState.vehCollected = []"
            :cases="$operators"/>
        @error('form.transporter')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </x-loading-field>
    <x-loading-field label="Driver Name" for="driver" required="true">
        <x-select-option
            id="driver" name="driver" type="text" class="mt-1 block w-full" autocomplete="driver" placeholder="Driver"
            wire:model="form.driver"
            :cases="$crews"
            areValueAndNameTheSame="true"/>
        @error('form.driver')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </x-loading-field>
    <x-loading-field label="Police Number" for="police_number" required="true">
        <x-text-search-option
            id="police_number" name="police_number" type="text" class="mt-1 block w-full" placeholder="Search Police Number"
            x-model="formState.vehicle"
            x-on:focus="open = formState.vehicles.length > 0"
            x-on:input.debounce.1500ms="$wire.searchVehicleBy(formState.vehicle)">

            <template x-for="(vehicle, i) in formState.vehicles" :key="i">
                <li x-on:click="open = false; formState.vehCollected[0] = vehicle; $wire.onVehicleSelected(vehicle)"
                    x-text="vehicle.plat" class="px-4 py-2 hover:bg-indigo-100 cursor-pointer"></li>
            </template>
        </x-text-search-option>
        <div>
            <template x-for="(veh, j) in formState.vehCollected" :key="j">
                <x-text-badge-with-close-button x-text="veh.plat+', '+veh.vendor" class="my-1 mx-1"/>
            </template>
        </div>
        @error('form.police_number')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </x-loading-field>

    <div>
        <x-input-label for="from_facility">
            From Facility<span class="text-red-500">&nbsp*</span>
        </x-input-label>
        <x-select-option wire:model="form.from_facility" :cases="$facilities" id="from_facility" name="from_facility" type="text" class="mt-1 block w-full"
                         autocomplete="from_facility" placeholder="From Facility"/>
        @error('form.from_facility')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="from_pit">
            From Pit<span class="text-red-500">&nbsp*</span>
        </x-input-label>
        <x-select-option wire:model="form.from_pit" :cases="$pits" id="from_pit" name="from_pit" type="text" class="mt-1 block w-full"
                         autocomplete="from_pit" placeholder="From Pit"/>
        @error('form.from_pit')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="to_facility">
            To Facility<span class="text-red-500">&nbsp*</span>
        </x-input-label>
        <x-select-option wire:model="form.to_facility" :cases="$facilities" id="to_facility" name="to_facility" type="text" class="mt-1 block w-full"
                         autocomplete="to_facility" placeholder="To Facility"/>
        @error('form.to_facility')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="type">
            Outgoing For<span class="text-red-500">&nbsp*</span>
        </x-input-label>
        <div id="type" class="flex flex-wrap ms-2 space-x-6">
            <div class="flex items-center">
                <input wire:model="form.type" value="{{$treatedWater}}" id="type" name="type" type="radio"
                       class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focusring-yellow-500 darkfocusring-yellow-600 darkring-offset-gray-800 focusring-2 darkbg-gray-700 darkborder-gray-600">
                <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 darktext-gray-300">{{$treatedWater}}</label>
            </div>
            <div class="flex items-center">
                <input wire:model="form.type" value="{{$concentratedWater}}" id="type" name="type" type="radio"
                       class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focusring-green-500 darkfocusring-green-600 darkring-offset-gray-800 focusring-2 darkbg-gray-700 darkborder-gray-600">
                <label for="green-radio" class="ms-2 text-sm font-medium text-gray-900 darktext-gray-300">{{$concentratedWater}}</label>
            </div>
        </div>
        @error('form.type')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="tds" :value="__('TDS/TSS')"/>
        <x-text-input wire:model="form.tds" id="tds" name="tds" type="number" pattern="[0-9]*" inputmode="numeric" min="0" class="mt-1 block w-full" autocomplete="tds"
                      placeholder="Tds"/>
        @error('form.tds')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="volume" :value="__('Volume (m3)')"/>
        <x-text-input wire:model="form.volume" id="volume" name="volume" type="number" pattern="[0-9]*" inputmode="numeric" min="0" class="mt-1 block w-full"
                      autocomplete="volume" placeholder="Volume"/>
        @error('form.volume')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="load">
            Load<span class="text-red-500">&nbsp*</span>
        </x-input-label>
        <x-text-input wire:model="form.load" id="load" name="load" type="number" pattern="[0-9]*" inputmode="numeric" min="1" max="999" class="mt-1 block w-full"
                      autocomplete="load" placeholder="Total Load"/>
        @error('form.load')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="remarks" :value="__('Remarks')"/>
        <x-text-input wire:model="form.remarks" id="remarks" name="remarks" type="text" class="mt-1 block w-full"
                      autocomplete="remarks" placeholder="Remarks"/>
        @error('form.remarks')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    @error('error')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
