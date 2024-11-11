<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Review') }} Trip Plan
    </h2>
</x-slot>

<div class="flex flex-col md:flex-row p-12 space-x-6 space-y-6">
    <div class="w-full md:w-3/12 sm:p-6 lg:p-8">
        @include('livewire.workorders.components.left-pane', [
            'postId' => $postId, 'steps' => $steps, 'stepAt' => \App\Models\TripPlan::ROUTE_POS
        ])
    </div>
    <div class="w-full md:w-9/12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Review') }} Trip Plan</h1>
                            <p class="mt-2 text-sm text-gray-700">Add a new {{ __('Trip Plan') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <div>
                                <x-input-label for="trip_times" :value="__('Trip times')"/>
                                <x-text-input disabled="$disabled" wire:model="tripTimes" wire:keydown.enter="onTripTimeKeyDownEnter" id="trip_times" name="trip_times" type="number" class="mt-1 block w-full" autocomplete="trip_times" min="3" max="100" placeholder="Trip times"/>
                                @error('tripTimes')
                                <x-input-error class="mt-2" :messages="$message"/>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <form method="POST" wire:submit="confirmThenNextToWorkOrder" role="form" enctype="multipart/form-data">
                                    @csrf
                                    @include('livewire.trip-plan.confirm', ['disabled' => $disabled, 'postId' => $postId])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
