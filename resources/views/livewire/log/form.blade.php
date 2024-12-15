<div class="space-y-6">
    
    <div>
        <x-input-label for="event" :value="__('Event')"/>
        <x-text-input wire:model="form.event" id="event" name="event" type="text" class="mt-1 block w-full" autocomplete="event" placeholder="Event"/>
        @error('form.event')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="highlight" :value="__('Highlight')"/>
        <x-text-input wire:model="form.highlight" id="highlight" name="highlight" type="text" class="mt-1 block w-full" autocomplete="highlight" placeholder="Highlight"/>
        @error('form.highlight')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="notification_count" :value="__('Notification Count')"/>
        <x-text-input wire:model="form.notification_count" id="notification_count" name="notification_count" type="text" class="mt-1 block w-full" autocomplete="notification_count" placeholder="Notification Count"/>
        @error('form.notification_count')
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
    <div>
        <x-input-label for="route_name" :value="__('Route Name')"/>
        <x-text-input wire:model="form.route_name" id="route_name" name="route_name" type="text" class="mt-1 block w-full" autocomplete="route_name" placeholder="Route Name"/>
        @error('form.route_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="url" :value="__('Url')"/>
        <x-text-input wire:model="form.url" id="url" name="url" type="text" class="mt-1 block w-full" autocomplete="url" placeholder="Url"/>
        @error('form.url')
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