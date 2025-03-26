@props(['disabled' => false])

<div>
    <div class="grid grid-cols-2 gap-4">

        <div>
            <x-input-label for="shift" :value="__('Shift')"/>
            <div id="shift" class="flex flex-wrap ms-2 space-x-6">
                <div class="flex items-center">
                    <input wire:model="form.shift" id="shift" name="shift" type="radio"
                           value="{{\App\Utils\PostWoInfoShiftEnum::DAY->value}}"
                           class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focusring-yellow-500 dark:focusring-yellow-600 dark:ring-offset-gray-800 focusring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="red-radio"
                           class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{\App\Utils\PostWoInfoShiftEnum::DAY->value}}</label>
                </div>
            </div>
            @error('form.shift')
            <x-input-error class="mt-2" messages="message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="act_name" :value="__('Event')"/>
            <x-select-option :cases="\App\Utils\ActNameEnum::cases()" wire:model="workTripForm.act_name"
                             wire:change="onActivityChange" id="act_name" name="act_name"/>
        </div>
        @if(!empty($workTripForm->act_name))
            <div>
                <x-input-label for="act_process" :value="__('Activity')"/>
                <x-select-option :cases="$processes" wire:model="workTripForm.act_process" id="act_process"
                                 name="act_process"/>
            </div>
            <div class="flex space-x-2">
                <div class="w-6/12">
                    <x-input-label for="act_value" :value="__('Quantity')"/>
                    <x-text-input type="number" wire:model="workTripForm.act_value" wire:change="onActValueChange"
                                  id="act_value" name="act_value" placeholder="Qty"/>
                    @error('workTripForm.act_process')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.act_value')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.type')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.date')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.time')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.act_name')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.act_unit')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.area_name')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.area_loc')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                    @error('workTripForm.post_id')
                    <x-input-error class="mt-2" :messages="$message"/>
                    @enderror
                </div>
                <div class="w-6/12">
                    <x-input-label for="act_unit" :value="__('UOM')"/>
                    <x-text-input type="text" :disabled="true" wire:model="workTripForm.act_unit" id="act_unit"
                                  name="act_unit" required/>
                </div>
            </div>
            <div class="m-auto">
                <button type="button" wire:click="onAddActivityPressed"
                        class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center inline-flex items-center rounded-full text-white bg-green-700 hoverbg-green-800 focusring-4 focusoutline-none focusring-blue-300 darkbg-blue-600 darkhoverbg-blue-700 darkfocusring-blue-800">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>
    @if(!empty($workTripsState))
        <table class="w-full divide-y divide-gray-300 mt-6">
            <thead>
            <tr>
                <th scope="col"
                    class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No
                </th>
                @foreach ($workTripsState as $i => $workTrip)
                    <th wire:click="onTableHeaderPressed({{$i}})" scope="col"
                        class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 hover:cursor-pointer hover:line-through hover:text-red-600 hover:font-semibold">
                        {{$workTrip['act_name'].' '.$workTrip['act_process']}}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">1.</td>
                @foreach ($workTripsState as $workTrip)
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                        {{ $workTrip['act_value'] }} {{ $workTrip['act_unit'] }} {{--m3 ~> &#13221; &#x33A5;--}}
                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    @endif
    <hr class="my-6">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="pick_up_from" :value="__('Pick Up From')"/>
            <x-text-search-option wire:model="form.pick_up_from" wire:keydown.shift="onPickUpFromChange"
                                  id="pick_up_from" name="pick_up_from">
                @foreach($searchedWells as $well)
                    <li @click="open = false" wire:click="onPickUpFromSelect('{{json_encode($well)}}')"
                        class="px-4 py-2 hover:bg-indigo-100 cursor-pointer">{{ $well->ids_wellname ?? $well->field_name ?? 'NA' }}</li>
                @endforeach
            </x-text-search-option>
            @error('form.pick_up_from')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="destination" :value="__('Destination')"/>
            <x-select-option wire:model="form.destination" wire:change="onDestChange" :cases="$locations"
                             id="destination" name="destination"/>
            @error('form.destination')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="req_qty" :value="__('Req Qty')"/>
            <x-text-input wire:model="form.req_qty" id="req_qty" name="req_qty" type="number" class="mt-1 block w-full"
                          autocomplete="req_qty" placeholder="Req Qty"/>
            @error('form.req_qty')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="rem_qty" :value="__('Rem Qty')"/>
            <x-text-input wire:model="form.rem_qty" id="rem_qty" name="rem_qty" type="number" class="mt-1 block w-full"
                          autocomplete="rem_qty" placeholder="Rem Qty"/>
            @error('form.rem_qty')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="required_date" :value="__('Required Date')"/>
            <x-text-input wire:model="form.required_date" id="required_date" name="required_date" type="datetime-local"
                          class="mt-1 block w-full" autocomplete="required_date" placeholder="Required Date"/>
            @error('form.required_date')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="yard" :value="__('Yard')"/>
            <x-text-input wire:model="form.yard" id="yard" name="yard" type="text" class="mt-1 block w-full"
                          autocomplete="yard" placeholder="Yard"/>
            <div class="grid grid-cols-2 gap-1 my-1">
                @foreach($yardSuggest as $text)
                    <x-text-badge wire:click="onYardSelected('{{$text}}')" label="{{$text}}"/>
                @endforeach
            </div>
            @error('form.yard')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        {{--<div>
            <x-input-label for="sch_qty" :value="__('Sch Qty')"/>
            <x-text-input wire:model="form.sch_qty" id="sch_qty" name="sch_qty" type="number" class="mt-1 block w-full" autocomplete="sch_qty" placeholder="Sch Qty"/>
            @error('form.sch_qty')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>--}}
        {{--<div>
            <x-input-label for="uom" :value="__('UOM')"/>
            <x-text-input wire:model="form.uom" id="uom" name="uom" type="text" class="mt-1 block w-full" autocomplete="uom" placeholder="UOM"/>
            @error('form.uom')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
            <div class="grid grid-cols-2 gap-1 my-1">
                @foreach($uomSuggest as $text)
                    <x-text-badge wire:click="onUomSelected('{{$text}}')" label="{{$text}}" />
                @endforeach
            </div>
        </div>--}}
        <div>
            <x-input-label for="rig_name" :value="__('Rig Name')"/>
            <x-text-input wire:model="form.rig_name" id="rig_name" name="rig_name" type="text" class="mt-1 block w-full"
                          autocomplete="rig_name" placeholder="Rig Name"/>
            @error('form.rig_name')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        {{--<div>
            <x-input-label for="trip" :value="__('Trip')"/>
            <x-text-input disabled="true" wire:model="form.trip" id="trip" name="trip" type="number" min="3" max="100" class="mt-1 block w-full" autocomplete="trip" placeholder="Trip"/>
        </div>--}}
        <div>
            <x-input-label for="wr_number" :value="__('Wr Number')"/>
            <x-text-input wire:model="form.wr_number" id="wr_number" name="wr_number" type="text"
                          class="mt-1 block w-full" autocomplete="wr_number" placeholder="Wr Number"/>
            @error('form.wr_number')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="pic" :value="__('PIC')"/>
            <x-text-input wire:model="form.pic" id="pic" name="pic" type="text" class="mt-1 block w-full"
                          autocomplete="pic" placeholder="PIC"/>
            @error('form.pic')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="charge" :value="__('Charge')"/>
            <x-text-input wire:model="form.charge" id="charge" name="charge" type="text" class="mt-1 block w-full"
                          autocomplete="charge" placeholder="Charge"/>
            @error('form.charge')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="status" :value="__('Status')"/>
            <x-text-input wire:model="form.status" id="status" name="status" type="text" class="mt-1 block w-full"
                          autocomplete="status" placeholder="Status"/>
            <div class="grid grid-cols-2 gap-1 my-1">
                @foreach($statusSuggest as $text)
                    <x-text-badge wire:click="onStatusSelected('{{$text}}')" label="{{$text}}"/>
                @endforeach
            </div>
            @error('form.status')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
            @error('form.post_id')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
            @error('form.trip')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')"/>
            <x-text-input wire:model="form.description" id="description" name="description" type="text"
                          class="mt-1 block w-full" placeholder="Description"/> {{--rows="3"--}}
            <div class="grid grid-cols-2 gap-1 my-1">
                @foreach($descSuggest as $text)
                    <x-text-badge wire:click="onDescriptionSelected('{{$text}}')" label="{{$text}}"/>
                @endforeach
            </div>
            @error('form.description')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>Submit</x-primary-button>
        </div>
    </div>
</div>
