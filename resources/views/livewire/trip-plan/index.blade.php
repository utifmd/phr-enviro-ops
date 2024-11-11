<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Trip Plans') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Trip Plans') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Trip Plans') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('trip-plans.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add new</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                    
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Start From</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Finish To</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Trip Type</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actual Start</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actual Finish</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Km Start</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Km End</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Km Actual</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Km Contract</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Start Working Date</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">End Working Date</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total Standby Hour</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total Working Hour</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Job Ticket Number</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Post Id</th>

                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($tripPlans as $tripPlan)
                                    <tr class="even:bg-gray-50" wire:key="{{ $tripPlan->id }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                        
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->start_from }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->finish_to }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->trip_type }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->actual_start }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->actual_finish }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->km_start }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->km_end }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->km_actual }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->km_contract }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->start_working_date }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->end_working_date }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->total_standby_hour }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->total_working_hour }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->job_ticket_number }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripPlan->post_id }}</td>

                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <a wire:navigate href="{{ route('trip-plans.show', $tripPlan->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                            <a wire:navigate href="{{ route('trip-plans.edit', $tripPlan->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                            <button
                                                class="text-red-600 font-bold hover:text-red-900"
                                                type="button"
                                                wire:click="delete({{ $tripPlan->id }})"
                                                wire:confirm="Are you sure you want to delete?"
                                            >
                                                {{ __('Delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 px-4">
                                {!! $tripPlans->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>