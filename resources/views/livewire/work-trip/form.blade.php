<div x-data="{ wells: @entangle('wells'), wellState:{isDrilling: true, text: '', drilling:[], mudPit:[]}, isAnotherDateOpen: false }" class="space-y-6">
    <div class="block md:grid md:grid-cols-4 space-y-4 md:space-y-0 gap-8">

        <div x-show="isAnotherDateOpen">
            <x-input-label @click="isAnotherDateOpen = !isAnotherDateOpen" class="cursor-pointer font-bold text-green-800" for="date" value="Another Date"/>
            <x-text-input class="mt-1 block w-full" type="date"
                wire:model="form.date"
                wire:change.prevent="onDateOptionChange"
                id="date" name="date"/>
            @error('form.date')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div x-show="!isAnotherDateOpen">
            <x-input-label @click="isAnotherDateOpen = !isAnotherDateOpen" class="cursor-pointer font-bold text-green-800" for="date" value="{{ 'Date'.($currentDate == date('Y-m-d') ? ' (Today)' : '') }}"/>
            <x-text-input
                class="mt-1 block w-full"
                :disabled="true"
                wire:model="form.date"
                id="date" name="date"/>

            @error('form.date')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        {{--<div>
            <x-input-label for="area_loc" :value="__('Location')"/>
            <x-select-option :cases="$locationOptions" wire:model="form.area_loc" id="area_loc" name="area_loc"/>
            @error('form.area_loc')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>--}}
        <div>
            <x-input-label for="time" value="Time"/>
            <x-select-option class="mt-1 block w-full" wire:model="form.time" wire:change.prevent="onTimeOptionChange" :cases="$timeOptions" :isIdle="false" id="time" name="time"/>
            @error('form.time')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="act_value" :value="__('Load (Actual)')"/>
            <x-text-input wire:model="form.act_value" id="act_value" name="act_value" type="number" pattern="[0-9]*" inputmode="numeric" min="0" max="999" class="mt-1 block w-full" autocomplete="act_value" placeholder="Quota"/>
            @error('form.act_value')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="btn_apply" :value="__('Reset & Apply to all')"/>
            <button id="btn_apply" name="btn_apply" type="button" x-on:click="$wire.welling(wells)" {{--wire:click="onStateInfoPressed"--}} class="mt-1 block p-3 text-xs font-medium text-center items-center rounded-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6"/></svg>
            </button>
        </div>
    </div>
    <div class="block md:grid md:grid-cols-3">
        <x-loading-field label="Well Name" for="well">
            <x-text-search-option x-model="wellState.well" x-on:input.debounce.1500ms="$wire.searchWellBy(wellState.well)" id="well" name="well" class="block w-full h-11" placeholder="Well Name">
                <template x-for="(well, i) in wells" :key="i">
                    <li x-on:click="open = false; wellState[wellState.isDrilling ? 'drilling' : 'mudPit'].push(well.ids_wellname);" x-text="well.ids_wellname" class="px-4 py-2 hover:bg-indigo-100 cursor-pointer"></li>
                </template>
            </x-text-search-option>
            @error('well')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </x-loading-field>
        {{--<div>
            <li class="flex items-center">
                <x-input-label for="well" x-on:click="wellState.isDrilling = !wellState.isDrilling" x-text="'Incoming '+ (wellState.isDrilling ? 'Drilling Site' : 'Mud Pit Closure')" --}}{{--:value="__('Well Name')"--}}{{--  class="cursor-pointer font-bold text-green-800"/>
                <div wire:loading role="status">
                    <svg aria-hidden="true" class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </li>
        </div>--}}
    </div>
    <div class="block md:grid md:grid-cols-3">
        <div>
            <x-input-label for="remarks" :value="$remarksAt"/>
            <x-textarea wire:model="remarks" id="remarks" name="remarks" class="mt-1 block w-full" placeholder="Notes"/>
            @error('remarks')
            <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
    </div>
    @include('livewire.work-trip.tabled')
    {{--@foreach($timeOptions as $timeOpt)
        @include('livewire.work-trip-info.tabled', ['timeOpt' => $timeOpt['value']])
    @endforeach--}}

    @error('error')
    <x-input-error class="mt-2" :messages="$message"/>
    @enderror
    <div class="flex items-center gap-4">
        <x-primary-button :disabled="count($tripState) == 0">{{$isEditMode ? 'Change' : 'Send'}}</x-primary-button>
    </div>
</div>
