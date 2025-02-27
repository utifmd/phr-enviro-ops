<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Incoming Log Sheet Report') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Incoming Log Sheet Report') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Incoming Log Sheet Report') }}.</p>
                    </div>
                    <div class="flex space-x-1 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <div class="flex space-x-1">
                            <div class="flex items-center">
                                <x-loading-indicator wire:loading />
                            </div>
                            <x-text-input wire:model="date" wire:change="onDateChange" type="date" min="2021-06-07T000000" max="{{date('Y-m-d')}}"/>
                        </div>
                    @can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW)
                        <a href="{{ route('work-trip-in-details.create') }}" class="flex hover:opacity-85" wire:navigate>
                            <x-general-button>Set Daily Incoming Log Sheet</x-general-button>
                        </a>
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
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Well Name</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Type</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rig Name</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Facility</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Wbs Number</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time Out</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Volume (m3)</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tds</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Load</th>
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
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['well_name'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['type'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['rig_name'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['facility'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['wbs_number'] }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->time_out }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->volume }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->tds }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->load }}</td>
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
