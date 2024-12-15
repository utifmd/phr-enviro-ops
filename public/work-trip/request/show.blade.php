<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex space-y-2 md:space-y-0">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $form->postModel->title }}</h1>
                        <p class="mt-2 text-sm text-gray-700">{{ $form->postModel->desc }}.</p>
                        <p class="mt-2 text-xs text-gray-800">
                            Requester: {{ $form->postModel->user->email ?? 'deleted account' }}
                            .</p>
                    </div>

                    <x-loading-indicator wire:loading />
                    <!-- Settings Dropdown -->
                    <x-dropdown-button>
                        @foreach($form->postModel->imageUrls as $uploaded)
                            <x-dropdown-link target="__blank" :href="$uploaded->url ?? '#'">
                                <!--wire:navigate>-->
                                {{ __('Evidence') }}
                            </x-dropdown-link>
                        @endforeach

                        @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                            <div class="w-full h-3.5"></div>
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
                        @canany([\App\Policies\UserPolicy::IS_USER_IS_FAC_REP, \App\Policies\PostPolicy::IS_THE_POST_STILL_PENDING], $form->postModel)
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
                                wire:click.prevent="onDeletePressed('{{$form->postModel->id}}')"
                                wire:confirm="Are you sure to delete this Well Loads?"
                                class="w-full text-start">
                                <x-dropdown-link class="text-red-600 font-bold">
                                    {{ __('Delete Permanently') }}
                                </x-dropdown-link>
                            </button>
                        @endcanany
                    </x-dropdown-button>
                </div>
                @if($form->postModel->workOrders)
                    <div class="flow-root">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full py-10 align-middle">
                                <table class="w-full divide-y divide-gray-300" wire:loading.class="opacity-50">
                                    <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            No
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Ids wellname
                                        </th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Shift
                                        </th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Rig/ Non Rig
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Load At
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Request Status
                                        </th>
                                        @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                            <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            </th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($form->postModel->workOrders as $i => $wo)
                                        <tr class="even:bg-gray-50" wire:key="{{ $wo['id'] }}">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}
                                                .
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wo['ids_wellname'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ucfirst(strtolower($wo['shift'])) }}
                                                Shift
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wo['is_rig'] ? 'Rig' : 'Non Rig' }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wo['created_at'] }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium">
                                                @if($wo['status'] == \App\Utils\WorkOrderStatusEnum::STATUS_PENDING->value)
                                                    <span class="text-yellow-300 font-bold"
                                                          type="button">{{ $wo['status'] }}</span>
                                                @elseif($wo['status'] == \App\Utils\WorkOrderStatusEnum::STATUS_REJECTED->value)
                                                    <span class="text-red-600 font-bold"
                                                          type="button">{{ $wo['status'] }}</span>
                                                @else
                                                    <span class="text-green-600 font-bold"
                                                          type="button">{{ $wo['status'] }}</span>
                                                @endif
                                            </td>
                                            @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 space-x-1">
                                                    <button wire:loading.attr="disabled"
                                                            wire:click.prevent="onChangeStatus('{{$wo['id']}}', '{{\App\Utils\WorkOrderStatusEnum::STATUS_REJECTED->value}}')"
                                                            class="px-3 border border-red-600 rounded text-red-600 hover:opacity-50">{{ __('Deny') }}</button>
                                                    <button wire:loading.attr="disabled"
                                                            wire:click.prevent="onChangeStatus('{{$wo['id']}}', '{{\App\Utils\WorkOrderStatusEnum::STATUS_ACCEPTED->value}}')"
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
