<div x-data="{ wellState:{isDrilling: true, text: '', wells:[], drilling:[], mudPit:[]} }" class="space-y-6">

    <x-loading-field label="Transporter" for="transporter">
        <x-select-option wire:model="form.transporter" :cases="$operators" id="transporter" name="transporter" type="text" class="mt-1 block w-full" autocomplete="transporter" placeholder="Transporter"/>
        @error('form.transporter')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </x-loading-field>
    <x-loading-field label="Driver Name" for="driver">
        <x-select-option wire:model="form.driver" :cases="$crews" id="driver" name="driver" type="text" class="mt-1 block w-full" autocomplete="driver" placeholder="Driver"/>
        @error('form.driver')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </x-loading-field>
    <div>
        <x-input-label for="police_number" :value="__('Police Number')"/>
        <x-text-input wire:model="form.police_number" id="police_number" name="police_number" type="text" class="mt-1 block w-full" autocomplete="police_number" placeholder="Police Number"/>
        @error('form.police_number')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    {{--<div>
        <x-input-label for="time_in" :value="__('Time In')"/>
        <x-text-input wire:model="form.time_in" id="time_in" name="time_in" type="text" class="mt-1 block w-full" autocomplete="time_in" placeholder="Time In"/>
        @error('form.time_in')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>--}}
    <div>
        <x-input-label for="time_in" value="Time In"/>
        <x-select-option class="mt-1 block w-full" wire:model="form.time_in" wire:change.prevent="onTimeOptionChange" :cases="$timeOptions" :isIdle="false" id="time_in" name="time_in"/>
        @error('form.time_in')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <li class="flex items-center">
            <x-input-label for="well" x-on:click="wellState.isDrilling = !wellState.isDrilling" x-text="'Incoming '+ (wellState.isDrilling ? 'Drilling Site' : 'Mud Pit Closure')" {{--:value="__('Well Name')"--}}  class="cursor-pointer font-bold text-green-800"/>
            <div wire:loading role="status">
                <svg aria-hidden="true" class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                <span class="sr-only">Loading...</span>
            </div>
        </li>
        <x-text-search-option x-model="wellState.well" x-on:input.debounce.1500ms="$wire.searchWellBy(wellState.well)" id="well" name="well" class="block w-full h-11" placeholder="Well Name">
            <template x-for="(well, i) in wellState.wells" :key="i">
                <li x-on:click="open = false; wellState[wellState.isDrilling ? 'drilling' : 'mudPit'].push(well.ids_wellname);" x-text="well.ids_wellname" class="px-4 py-2 hover:bg-indigo-100 cursor-pointer"></li>
            </template>
        </x-text-search-option>
        @error('well')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="well_name" :value="__('Well Name')"/>
        <x-text-input wire:model="form.well_name" id="well_name" name="well_name" type="text" class="mt-1 block w-full" autocomplete="well_name" placeholder="Well Name"/>
        @error('form.well_name')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="type" :value="__('Type')"/>
        <x-text-input wire:model="form.type" id="type" name="type" type="text" class="mt-1 block w-full" autocomplete="type" placeholder="Type"/>
        @error('form.type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="rig_name" :value="__('Rig Name')"/>
        <x-text-input wire:model="form.rig_name" id="rig_name" name="rig_name" type="text" class="mt-1 block w-full" autocomplete="rig_name" placeholder="Rig Name"/>
        @error('form.rig_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="load" :value="__('Load')"/>
        <x-text-input wire:model="form.load" id="load" name="load" type="text" class="mt-1 block w-full" autocomplete="load" placeholder="Load"/>
        @error('form.load')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="volume" :value="__('Volume')"/>
        <x-text-input wire:model="form.volume" id="volume" name="volume" type="text" class="mt-1 block w-full" autocomplete="volume" placeholder="Volume"/>
        @error('form.volume')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="tds" :value="__('Tds')"/>
        <x-text-input wire:model="form.tds" id="tds" name="tds" type="text" class="mt-1 block w-full" autocomplete="tds" placeholder="Tds"/>
        @error('form.tds')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="facility" :value="__('Facility')"/>
        <x-text-input wire:model="form.facility" id="facility" name="facility" type="text" class="mt-1 block w-full" autocomplete="facility" placeholder="Facility"/>
        @error('form.facility')
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
        <x-input-label for="wbs_number" :value="__('Wbs Number')"/>
        <x-text-input wire:model="form.wbs_number" id="wbs_number" name="wbs_number" type="text" class="mt-1 block w-full" autocomplete="wbs_number" placeholder="Wbs Number"/>
        @error('form.wbs_number')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="time_out" value="Time Out"/>
        <x-select-option class="mt-1 block w-full" wire:model="form.time_out" wire:change.prevent="onTimeOptionChange" :cases="$timeOptions" :isIdle="false" id="time_out" name="time_out"/>
        @error('form.time_out')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="remarks" :value="__('Remarks')"/>
        <x-text-input wire:model="form.remarks" id="remarks" name="remarks" type="text" class="mt-1 block w-full" autocomplete="remarks" placeholder="Remarks"/>
        @error('form.remarks')
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
    <div>
        <x-input-label for="user_id" :value="__('User Id')"/>
        <x-text-input wire:model="form.user_id" id="user_id" name="user_id" type="text" class="mt-1 block w-full" autocomplete="user_id" placeholder="User Id"/>
        @error('form.user_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
