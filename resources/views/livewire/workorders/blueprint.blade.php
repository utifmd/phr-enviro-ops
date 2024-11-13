<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Print') }} Work Order
    </h2>
</x-slot>

<div class="flex flex-col md:flex-row p-12 space-x-6 space-y-6">
    <div class="w-full md:w-3/12 sm:p-6 lg:p-8">
        @include('livewire.workorders.components.left-pane', [
            'steps' => $steps, 'stepAt' => 4
        ])
    </div>
    <div class="w-full md:w-9/12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg ">
                <div class="w-full">
                    @if(session()->has('message'))
                        <div class="flex">
                            <div class="alert alert-success">
                                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                    <span class="font-medium">Success!</span> {{ session('message') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Print') }} Work Order</h1>
                            <p class="mt-2 text-sm text-gray-700">Add a new {{ __('Work Order') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <x-general-button wire:loading.attr="disabled" wire:click="export">Export</x-general-button>
                            <x-general-button :disabled="$disabled" wire:loading.attr="disabled" wire:click="finish" wire:confirm="Are you sure you want to finish workorder?">Finish</x-general-button>
                            {{--<div>
                                <x-input-label for="trip_times" :value="__('Trip times')"/>
                                <x-text-input wire:model="tripTimes" wire:keydown.enter="onTripTimeKeyDownEnter" id="trip_times" name="trip_times" type="number" class="mt-1 block w-full" autocomplete="trip_times" min="3" max="100" placeholder="Trip times"/>
                                @error('tripTimes')
                                <x-input-error class="mt-2" :messages="$message"/>
                                @enderror
                            </div>--}}
                        </div>
                    </div>

                    <div class="flow-root">
                        @include('livewire.workorders.blueprint-tabled')

                        {{--<form method="POST" wire:submit="" role="form" enctype="multipart/form-data">
                            @csrf
                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
