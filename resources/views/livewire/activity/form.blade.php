<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" placeholder="Name"/>
        @error('form.name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="process" :value="__('Process')"/>
        <x-text-input wire:model="form.process" id="process" name="process" type="text" class="mt-1 block w-full" autocomplete="process" placeholder="Process"/>
        @error('form.process')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="unit" :value="__('Unit')"/>
        <x-text-input wire:model="form.unit" id="unit" name="unit" type="text" class="mt-1 block w-full" autocomplete="unit" placeholder="Unit"/>
        @error('form.unit')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>