<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label for="required_date" :value="__('Required Date')"/>
        <x-text-input wire:model="form.required_date" id="required_date" name="required_date" type="datetime-local" class="mt-1 block w-full" autocomplete="required_date" placeholder="Required Date"/>
        @error('form.required_date')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="yard" :value="__('Yard')"/>
        <x-text-input wire:model="form.yard" id="yard" name="yard" type="text" class="mt-1 block w-full" autocomplete="yard" placeholder="Yard"/>
        @error('form.yard')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        <div class="grid grid-cols-2 gap-1 my-1">
            @foreach($yardSuggest as $text)
                <x-text-badge wire:click="onYardSelected('{{$text}}')" label="{{$text}}" />
            @endforeach
        </div>
    </div>
    <div>
        <x-input-label for="req_qty" :value="__('Req Qty')"/>
        <x-text-input wire:model="form.req_qty" id="req_qty" name="req_qty" type="number" class="mt-1 block w-full" autocomplete="req_qty" placeholder="Req Qty"/>
        @error('form.req_qty')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="rem_qty" :value="__('Rem Qty')"/>
        <x-text-input wire:model="form.rem_qty" id="rem_qty" name="rem_qty" type="number" class="mt-1 block w-full" autocomplete="rem_qty" placeholder="Rem Qty"/>
        @error('form.rem_qty')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="sch_qty" :value="__('Sch Qty')"/>
        <x-text-input wire:model="form.sch_qty" id="sch_qty" name="sch_qty" type="number" class="mt-1 block w-full" autocomplete="sch_qty" placeholder="Sch Qty"/>
        @error('form.sch_qty')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
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
    </div>
    <div>
        <x-input-label for="pick_up_from" :value="__('Pick Up From')"/>
        <x-text-input wire:model="form.pick_up_from" id="pick_up_from" name="pick_up_from" type="text" class="mt-1 block w-full" autocomplete="pick_up_from" placeholder="Pick Up From"/>
        @error('form.pick_up_from')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="destination" :value="__('Destination')"/>
        <x-text-input wire:model="form.destination" id="destination" name="destination" type="text" class="mt-1 block w-full" autocomplete="destination" placeholder="Destination"/>
        @error('form.destination')
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
        <x-input-label for="trip" :value="__('Trip')"/>
        <x-text-input wire:model="form.trip" id="trip" name="trip" type="number" min="3" max="100" class="mt-1 block w-full" autocomplete="trip" placeholder="Trip"/>
        @error('form.trip')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="wr_number" :value="__('Wr Number')"/>
        <x-text-input wire:model="form.wr_number" id="wr_number" name="wr_number" type="text" class="mt-1 block w-full" autocomplete="wr_number" placeholder="Wr Number"/>
        @error('form.wr_number')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="pic" :value="__('PIC')"/>
        <x-text-input wire:model="form.pic" id="pic" name="pic" type="text" class="mt-1 block w-full" autocomplete="pic" placeholder="PIC"/>
        @error('form.pic')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="change" :value="__('Change')"/>
        <x-text-input wire:model="form.change" id="change" name="change" type="text" class="mt-1 block w-full" autocomplete="change" placeholder="Change"/>
        @error('form.change')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input wire:model="form.status" id="status" name="status" type="text" class="mt-1 block w-full" autocomplete="status" placeholder="Status"/>
        @error('form.status')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        <div class="grid grid-cols-2 gap-1 my-1">
            @foreach($statusSuggest as $text)
                <x-text-badge wire:click="onStatusSelected('{{$text}}')" label="{{$text}}" />
            @endforeach
        </div>
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <x-textarea wire:model="form.description" rows="3" placeholder="Describe order detail" />
        @error('form.description')
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
        <x-primary-button disabled="{{$disabled}}">Submit</x-primary-button>
    </div>
</div>
