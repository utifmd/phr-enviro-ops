<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex space-y-2 md:space-y-0">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $form->postModel->title }}</h1>
                        <p class="mt-2 text-sm text-gray-700">{{ $form->postModel->description }}.</p>
                        @if($remarks = $form->postModel->remarks['message'] ?? false)
                            <p class="mt-2 text-sm text-gray-700 italic"><span>Remarks:</span> {{ $remarks }}.</p>
                        @endif
                        <p class="mt-2 text-xs text-gray-800">Facility Representative: {{ $form->postModel->user->email ?? 'deleted account' }}</p>
                    </div>

                    <x-loading-indicator wire:loading />
                    {{--<div>
                        <x-input-label for="time" value="Filter by Time"/>
                        <x-select-option
                            class="mt-1 block w-full"
                            wire:model="time"
                            wire:change.prevent="onTimeOptionChange"
                            :cases="$timeOptions" :isIdle="false" id="time" name="time"/>
                        @error('time')
                        <x-input-error class="mt-2" :messages="$message"/>
                        @enderror
                    </div>--}}

                    <!-- Settings Dropdown -->
                    <x-dropdown-button>
                        @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                            <x-dropdown-link :href="route('work-trips.requests.index')" wire:loading.attr="disabled">
                                {{ __('All Actual') }}
                            </x-dropdown-link>
                            <div class="w-full my-4">
                                <hr>
                            </div>
                            <!-- Authentication -->
                            <button wire:loading.attr="disabled"
                                    wire:click.prevent="onAllowAllRequestPressed"
                                    wire:confirm="Are you sure to close & approve all log sheets?"
                                    class="w-full text-start">
                                <x-dropdown-link class="text-green-600">
                                    {{ __('Close & Approve All Request') }}
                                </x-dropdown-link>
                            </button>
                            <button wire:loading.attr="disabled"
                                    wire:click.prevent="onDeniedAllRequestPressed"
                                    wire:confirm="Are you sure to reject this Well Loads Request?"
                                    class="w-full text-start">
                                <x-dropdown-link class="text-red-600">
                                    {{ __('Open & Reject All Request') }}
                                </x-dropdown-link>
                            </button>
                        @endcan
                    </x-dropdown-button>
                </div>

                @error('error')
                    <x-input-error class="mt-2" :messages="$message"/>
                @enderror
                <div class="flow-root">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full py-10 align-middle">
                            @foreach($workTrips as $time => $trips)
                                <p class="my-4 font-semibold text-gray-900">&#128339; {{ $time }}</p>
                                <table wire:loading.class="opacity-50" class="w-full divide-y divide-gray-300 mb-8">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Activity</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Facility</th>
                                        {{--<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Datetime</th>--}}
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total (Actual)</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Send By</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Request Status</th>
                                        @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                            <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            </th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($trips as $i => $trip)
                                        <tr class="even:bg-gray-50" wire:key="{{ $trip['id'] }}">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{++$i}}.</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['act_name'] }} {{ $trip['act_process'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['area_loc'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['act_value'] .' '. $trip['act_unit'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['user']['name'] ?? 'NA' }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium">
                                                @if($trip['status'] == \App\Utils\WorkTripStatusEnum::PENDING->value)
                                                    <span class="text-yellow-300 font-bold"
                                                          type="button">{{ $trip['status'] }}</span>
                                                @elseif($trip['status'] == \App\Utils\WorkTripStatusEnum::REJECTED->value)
                                                    <span class="text-red-600 font-bold"
                                                          type="button">{{ $trip['status'] }}</span>
                                                @else
                                                    <span class="text-green-600 font-bold"
                                                          type="button">{{ $trip['status'] }}</span>
                                                @endif
                                            </td>
                                            @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 space-x-1">
                                                    <button wire:loading.attr="disabled"
                                                            wire:click.prevent="onChangeStatus('{{$trip['id']}}', '{{\App\Utils\WorkTripStatusEnum::REJECTED->value}}')"
                                                            class="px-3 border border-red-600 rounded text-red-600 hover:opacity-50">{{ __('Deny') }}</button>
                                                    <button wire:loading.attr="disabled"
                                                            wire:click.prevent="onChangeStatus('{{$trip['id']}}', '{{\App\Utils\WorkTripStatusEnum::APPROVED->value}}')"
                                                            class="px-3 border border-green-600 rounded text-green-600 hover:opacity-50">{{ __('Allow') }}</button>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
