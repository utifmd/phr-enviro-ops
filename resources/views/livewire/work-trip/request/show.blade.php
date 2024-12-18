<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex space-y-2 md:space-y-0">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $form->postModel->title }}</h1>
                        <p class="mt-2 text-sm text-gray-700">{{ $form->postModel->description }}.</p>
                        <p class="mt-2 text-xs text-gray-800">Facility Representative: {{ $form->postModel->user->email ?? 'deleted account' }}</p>
                    </div>

                    <div wire:loading role="status"> {{-- wire:target="btn_delete"--}}
                        <svg aria-hidden="true"
                             class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                             viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor"/>
                            <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="min-w-md md:mx-2">
                        <x-input-label for="options" :value="__('Options')"/>
                        <x-dropdown id="options" align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                        class="px-2.5 bg-gray-50 text-gray-900 border border-gray-300 shadow-sm rounded focus:outline-none hover:opacity-50">
                                    <div x-data="Option" x-text="name"
                                         x-on:profile-updated.window="name = $event.detail.name"></div>

                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="4"
                                              d="M6 12h.01m6 0h.01m5.99 0h.01"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                {{--@foreach($form->postModel->imageUrls as $uploaded)
                                    <x-dropdown-link target="__blank" :href="$uploaded->url ?? '#'">
                                        <!--wire:navigate>-->
                                        {{ __('Evidence') }}
                                    </x-dropdown-link>
                                @endforeach--}}

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
                                            wire:confirm="Are you sure to accept this Well Loads Request?"
                                            class="w-full text-start">
                                        <x-dropdown-link class="text-green-600">
                                            {{ __('Allowed All Request') }}
                                        </x-dropdown-link>
                                    </button>
                                    <button wire:loading.attr="disabled"
                                            wire:click.prevent="onDeniedAllRequestPressed"
                                            wire:confirm="Are you sure to reject this Well Loads Request?"
                                            class="w-full text-start">
                                        <x-dropdown-link class="text-red-600">
                                            {{ __('Denied All Request') }}
                                        </x-dropdown-link>
                                    </button>
                                @endcan
                                {{--@canany([\App\Policies\UserPolicy::IS_USER_IS_FAC_REP, \App\Policies\PostPolicy::IS_THE_POST_STILL_PENDING], $form->postModel)
                                    <div class="w-full h-3.5"></div>
                                    <x-dropdown-link
                                            wire:navigate
                                            type="button"
                                            href="{{ route('work-trips.edit', $form->postModel->id) }}"
                                            wire:loading.attr="disabled" class="text-yellow-300 font-bold">
                                        {{ __('Update Request') }}
                                    </x-dropdown-link>
                                    <button
                                            wire:loading.attr="disabled"
                                            --}}{{--wire:click.prevent="onDeletePressed('{{$form->postModel->id}}')"--}}{{--
                                            wire:confirm="Are you sure to delete this Well Loads?"
                                            class="w-full text-start">
                                        <x-dropdown-link class="text-red-600 font-bold">
                                            {{ __('Delete Permanently') }}
                                        </x-dropdown-link>
                                    </button>
                                @endcanany--}}
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
                @if($workTrips)
                    <div class="flow-root">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full py-10 align-middle">
                                <table class="w-full divide-y divide-gray-300" wire:loading.class="opacity-50">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Activity</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Location</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Datetime</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total (Actual)</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actual By</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Request Status</th>
                                    @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                            <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            </th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($workTrips as $i => $trip)
                                        <tr class="even:bg-gray-50" wire:key="{{ $trip['id'] }}">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}.</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['act_name'] }} {{ $trip['act_process'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['area_loc'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $trip['date'] }} {{ $trip['time'] }}</td>
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
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
