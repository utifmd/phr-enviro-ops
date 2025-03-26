<div class="space-y-6">
    {{--<table class="divide-y divide-gray-300 mt-6">
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">TDS < 4000</td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">COD < 300</td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">8 Parameter</td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">Location</td>
        </tr>
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                TDS < 4000 COD < 300 & Memenuhi 8 Baku Mutu Parameter
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <span>GS/CGS</span>
            </td>
        </tr>
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <span>GS/CGS</span>
            </td>
        </tr>
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </td>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                <span>CMTF</span>
            </td>
        </tr>
    </table>--}}
    {{--<div class="w-full grid grid-cols-1 gap-2">--}}

    <div class="w-full grid grid-cols-2 gap-6">
        <div>
            <x-input-label for="act_name" :value="__('Activity')"/>
            <x-radio-button
                :cases="\App\Utils\ActNameEnum::cases()"
                wire:model="form.act_name"
                wire:change="onActivityChange"
                id="act_name" name="act_name"/>

            @error('form.act_name')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="act_process" :value="__('Process')"/>
            <x-select-option :cases="$processes" wire:model="form.act_process" id="act_process" name="act_process"/>
            @error('form.act_process')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="area_loc" :value="__('Location')"/>
            <x-select-option :cases="$locations" wire:model="form.area_loc" id="area_loc" name="area_loc"/>
        </div>
        <div>
            <x-input-label for="time" value="{{ date('d M Y') }}"/>
            <x-select-option wire:model="form.time" :cases="$periods" :isIdle="false" id="time" name="time"/>
            @error('form.time')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div class="flex flex-row space-x-2 items-end">
            <div class="grow">
                <x-input-label for="act_value" value="{{ 'Quota (Actual/Planning)' }}"/>
                <x-text-input type="text" pattern="[0-9]{1,3}/[0-9]{1,3}" wire:model="form.act_value" id="act_value" name="act_value"
                              placeholder="000/000"/>
            </div>
            <div class="w-16">
                <x-input-label for="act_unit" :value="__('UOM')"/>
                <x-text-input type="text" disabled="true" wire:model="form.act_unit" id="act_unit" name="act_unit"
                              placeholder="Unit" required/>
            </div>
            <div class="w-26 flex space-x-2 p-3">
                <button
                    type="button" wire:click="onStateActivityPressed"
                    class="block w-full p-3 text-xs font-medium text-center items-center rounded-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6"/>
                    </svg>
                </button>
                @if($isEditMode)
                    <button
                        type="button" wire:click=""
                        class="w-full text-xs text-center items-center rounded px-2 text-red-600 font-bold bg-yellow-300 hover:bg-yellow-400">
                        Delete
                    </button>
                @endif
            </div>
        </div>
        {{--@if(!empty($form->act_name)) @endif--}}
    </div>

    @error('form.area_loc')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.area_name')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.date')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.time')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.type')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.act_value')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.act_unit')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('form.post_id')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    @error('error')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
{{--
<div class="space-y-6">
    <div>
        <x-input-label for="type" :value="__('Type')"/>
        <x-text-input wire:model="form.type" id="type" name="type" type="text" class="mt-1 block w-full" autocomplete="type" placeholder="Type"/>
        @error('form.type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="date" :value="__('Date')"/>
        <x-text-input wire:model="form.date" id="date" name="date" type="text" class="mt-1 block w-full" autocomplete="date" placeholder="Date"/>
        @error('form.date')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="time" :value="__('Time')"/>
        <x-text-input wire:model="form.time" id="time" name="time" type="text" class="mt-1 block w-full" autocomplete="time" placeholder="Time"/>
        @error('form.time')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="act_name" :value="__('Act Name')"/>
        <x-text-input wire:model="form.act_name" id="act_name" name="act_name" type="text" class="mt-1 block w-full" autocomplete="act_name" placeholder="Act Name"/>
        @error('form.act_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="act_process" :value="__('Act Process')"/>
        <x-text-input wire:model="form.act_process" id="act_process" name="act_process" type="text" class="mt-1 block w-full" autocomplete="act_process" placeholder="Act Process"/>
        @error('form.act_process')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="act_unit" :value="__('Act Unit')"/>
        <x-text-input wire:model="form.act_unit" id="act_unit" name="act_unit" type="text" class="mt-1 block w-full" autocomplete="act_unit" placeholder="Act Unit"/>
        @error('form.act_unit')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="act_value" :value="__('Act Value')"/>
        <x-text-input wire:model="form.act_value" id="act_value" name="act_value" type="text" class="mt-1 block w-full" autocomplete="act_value" placeholder="Act Value"/>
        @error('form.act_value')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="area_name" :value="__('Area Name')"/>
        <x-text-input wire:model="form.area_name" id="area_name" name="area_name" type="text" class="mt-1 block w-full" autocomplete="area_name" placeholder="Area Name"/>
        @error('form.area_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="area_loc" :value="__('Area Loc')"/>
        <x-text-input wire:model="form.area_loc" id="area_loc" name="area_loc" type="text" class="mt-1 block w-full" autocomplete="area_loc" placeholder="Area Loc"/>
        @error('form.area_loc')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="post_id" :value="__('Post Id')"/>
        <x-text-input wire:model="form.post_id" id="post_id" name="post_id" type="text" class="mt-1 block w-full" autocomplete="post_id" placeholder="Post Id"/>
        @error('form.post_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>--}}
