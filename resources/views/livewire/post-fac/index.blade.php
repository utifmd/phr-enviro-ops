<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Facility Log Sheet') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Facility Log Sheet') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Facility Log Sheet') }}.</p>
                    </div>
                    <div class="flex space-x-1 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <div class="flex space-x-2">
                            <div class="flex items-center">
                                <x-loading-indicator wire:loading/>
                            </div>
                            <div>
                                <x-text-input wire:model="date" wire:change="onDateChange" type="date"
                                              min="2021-06-07T000000" max="{{date('Y-m-d')}}"/>
                            </div>
                            <div>
                                <x-select-option wire:model="type" wire:change="onTypeChange"
                                                 :cases="\App\Utils\ActNameEnum::cases()" :isIdle="false"/>
                            </div>

                            @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                <a class="flex hover:opacity-85"
                                   href="{{ route('post-fac.export', compact('date', 'type')) }}">
                                    <x-general-button>Export To Excel</x-general-button>
                                </a>
                                {{--<x-menu>
                                    <x-dropdown-link href="{{ route('post-fac.export', compact('date', 'type')) }}" class="text-green-600 cursor-pointer">
                                        {{ __('Export To Excel') }}
                                    </x-dropdown-link>
                                </x-menu>--}}
                            @endcan
                        </div>
                        {{--<a type="button" wire:navigate href="{{ route('post-fac.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add new</a>--}}
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            @include('livewire.post-fac.tabled')

                            <div class="mt-4 px-4">
                                {!! $workTripDetails->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
