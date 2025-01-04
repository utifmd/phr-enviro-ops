<div class="space-y-6">
    
    <div>
        <x-input-label for="transporter" :value="__('Transporter')"/>
        <x-text-input wire:model="form.transporter" id="transporter" name="transporter" type="text" class="mt-1 block w-full" autocomplete="transporter" placeholder="Transporter"/>
        @error('form.transporter')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="driver" :value="__('Driver')"/>
        <x-text-input wire:model="form.driver" id="driver" name="driver" type="text" class="mt-1 block w-full" autocomplete="driver" placeholder="Driver"/>
        @error('form.driver')
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
        <x-input-label for="time_in" :value="__('Time In')"/>
        <x-text-input wire:model="form.time_in" id="time_in" name="time_in" type="text" class="mt-1 block w-full" autocomplete="time_in" placeholder="Time In"/>
        @error('form.time_in')
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
        <x-input-label for="time_out" :value="__('Time Out')"/>
        <x-text-input wire:model="form.time_out" id="time_out" name="time_out" type="text" class="mt-1 block w-full" autocomplete="time_out" placeholder="Time Out"/>
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