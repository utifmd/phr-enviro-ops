<div class="space-y-6">

    <div>
        <x-input-label for="start_from" :value="__('Start From')"/>
        <x-text-input wire:model="form.start_from" id="start_from" name="start_from" type="text" class="mt-1 block w-full" autocomplete="start_from" placeholder="Start From"/>
        @error('form.start_from')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="finish_to" :value="__('Finish To')"/>
        <x-text-input wire:model="form.finish_to" id="finish_to" name="finish_to" type="text" class="mt-1 block w-full" autocomplete="finish_to" placeholder="Finish To"/>
        @error('form.finish_to')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="trip_type" :value="__('Trip Type')"/>
        <x-text-input wire:model="form.trip_type" id="trip_type" name="trip_type" type="text" class="mt-1 block w-full" autocomplete="trip_type" placeholder="Trip Type"/>
        @error('form.trip_type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="actual_start" :value="__('Actual Start')"/>
        <x-text-input wire:model="form.actual_start" id="actual_start" name="actual_start" type="text" class="mt-1 block w-full" autocomplete="actual_start" placeholder="Actual Start"/>
        @error('form.actual_start')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="actual_finish" :value="__('Actual Finish')"/>
        <x-text-input wire:model="form.actual_finish" id="actual_finish" name="actual_finish" type="text" class="mt-1 block w-full" autocomplete="actual_finish" placeholder="Actual Finish"/>
        @error('form.actual_finish')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="km_start" :value="__('Km Start')"/>
        <x-text-input wire:model="form.km_start" id="km_start" name="km_start" type="text" class="mt-1 block w-full" autocomplete="km_start" placeholder="Km Start"/>
        @error('form.km_start')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="km_end" :value="__('Km End')"/>
        <x-text-input wire:model="form.km_end" id="km_end" name="km_end" type="text" class="mt-1 block w-full" autocomplete="km_end" placeholder="Km End"/>
        @error('form.km_end')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="km_actual" :value="__('Km Actual')"/>
        <x-text-input wire:model="form.km_actual" id="km_actual" name="km_actual" type="text" class="mt-1 block w-full" autocomplete="km_actual" placeholder="Km Actual"/>
        @error('form.km_actual')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="km_contract" :value="__('Km Contract')"/>
        <x-text-input wire:model="form.km_contract" id="km_contract" name="km_contract" type="text" class="mt-1 block w-full" autocomplete="km_contract" placeholder="Km Contract"/>
        @error('form.km_contract')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="start_working_date" :value="__('Start Working Date')"/>
        <x-text-input wire:model="form.start_working_date" id="start_working_date" name="start_working_date" type="text" class="mt-1 block w-full" autocomplete="start_working_date" placeholder="Start Working Date"/>
        @error('form.start_working_date')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="end_working_date" :value="__('End Working Date')"/>
        <x-text-input wire:model="form.end_working_date" id="end_working_date" name="end_working_date" type="text" class="mt-1 block w-full" autocomplete="end_working_date" placeholder="End Working Date"/>
        @error('form.end_working_date')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="total_standby_hour" :value="__('Total Standby Hour')"/>
        <x-text-input wire:model="form.total_standby_hour" id="total_standby_hour" name="total_standby_hour" type="text" class="mt-1 block w-full" autocomplete="total_standby_hour" placeholder="Total Standby Hour"/>
        @error('form.total_standby_hour')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="total_working_hour" :value="__('Total Working Hour')"/>
        <x-text-input wire:model="form.total_working_hour" id="total_working_hour" name="total_working_hour" type="text" class="mt-1 block w-full" autocomplete="total_working_hour" placeholder="Total Working Hour"/>
        @error('form.total_working_hour')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="job_ticket_number" :value="__('Job Ticket Number')"/>
        <x-text-input wire:model="form.job_ticket_number" id="job_ticket_number" name="job_ticket_number" type="text" class="mt-1 block w-full" autocomplete="job_ticket_number" placeholder="Job Ticket Number"/>
        @error('form.job_ticket_number')
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
