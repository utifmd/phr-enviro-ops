<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Outgoing Log Sheet Report') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Outgoing Log Sheet Report') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Outgoing Log Sheet Report') }}.</p>
                    </div>
                    <div class="flex space-x-1 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <div class="flex space-x-1">
                            <div class="flex items-center">
                                <x-loading-indicator wire:loading />
                            </div>
                            <x-text-input wire:model="date" wire:change="onDateChange" type="date" min="2021-06-07T000000" max="{{date('Y-m-d')}}"/>
                        </div>
                    @can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW)
                        <div>
                            <a type="button" wire:navigate href="{{ route('work-trip-out-details.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Set Daily Outgoing Log Sheet</a>
                        </div>
                    @endcan
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Transporter</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Driver</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Police Number</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time In</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time Out</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">From Pit</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">From Facility</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">To Facility</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Type</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tds</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Volume</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Load</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Area Name</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Remarks</th>

                                    @can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW)
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($workTripDetails as $workTripDetail)
                                    <tr class="even:bg-gray-50" wire:key="{{ $workTripDetail->id }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ date('Y-m-d', strtotime($workTripDetail->created_at)) }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->transporter }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->driver }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->police_number }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->time_in }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->time_out }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['from_pit'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['from_facility'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['to_facility'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['type'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->tds }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->volume }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->load }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->area_name }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->remarks }}</td>

                                        @can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW)
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <a wire:navigate href="{{ route('work-trip-in-details.show', $workTripDetail->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                                <a wire:navigate href="{{ route('work-trip-in-details.edit', $workTripDetail->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                                <button
                                                    class="text-red-600 font-bold hover:text-red-900"
                                                    type="button"
                                                    wire:click="delete('{{ $workTripDetail->id }}')"
                                                    wire:confirm="Are you sure you want to delete?">
                                                    {{ __('Delete') }}
                                                </button>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="17" class="border border-gray-300 px-4 py-2 text-center">Please filter the table record by date.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

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
