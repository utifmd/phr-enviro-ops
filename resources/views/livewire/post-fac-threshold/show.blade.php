<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $workTripInfo->name ?? __('Show') . " " . __('Facility Plan') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Show') }} Facility Plan</h1>
                        <p class="mt-2 text-sm text-gray-700">Details of {{ __('Facility Plan') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('post-fac-threshold.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="mt-6 border-t border-gray-100">
                                <dl class="divide-y divide-gray-100">

                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Date</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->date }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Time</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->time }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Act Name</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->act_name }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Act Process</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->act_process }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Act Unit</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->act_unit }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Act Value</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->act_value }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Area Name</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->area_name }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Area Loc</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->area_loc }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">User Id</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $workTripInfo->user_id }}</dd>
                                    </div>

                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
