<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $facility . __(' Monthly Report') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $facility . __(' Monthly Report') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">Incoming from Drilling Site or Mud Pit Closure by VT and WT for Un/Loading Activities to {{ $facility . __(' Facility') }}.</p>
                    </div>
                    <div class="flex space-x-1 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <div class="flex space-x-2">
                            <div class="flex items-center">
                                <x-loading-indicator wire:loading />
                            </div>
                            <div>
                                <x-text-input wire:model="date" wire:change="onDateChange" type="month"/>
                            </div>
                            @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                <a class="flex hover:opacity-85" href="{{ route('work-trip.export', compact('date')) }}">
                                    <x-general-button>Export To Excel</x-general-button>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            @include('livewire.work-trip-detail.report.tabled')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
