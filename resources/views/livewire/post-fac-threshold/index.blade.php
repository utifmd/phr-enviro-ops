@props(['area' => $authUsr['area_name'] ?? null])
@props(['tile' => $area ? ' Area '.ucfirst(strtolower($area)) : ''])

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Facility Plan') }}
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Facility Plan'). $tile }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Facility Plan'). $tile }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('post-fac-threshold.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Plan</a>
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
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Plan By</th>

                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($infoState as $info)
                                    <tr class="even:bg-gray-50" wire:key="{{ $info->date }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}.</td>

										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ trim($info->date.' '.($info->date == date('Y-m-d') ? '(Today)' : '')) }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $info->act_value_sum }} {{ $info->act_unit }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $info->user }}</td>

                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <a wire:navigate href="{{ route('post-fac-threshold.create-by', $info->date) }}" class="text-yellow-500 font-bold hover:text-yellow-800 mr-2">{{ __('Show & Edit') }}</a>
                                            <button
                                                class="text-red-600 font-bold hover:text-red-900"
                                                type="button"
                                                wire:click="delete('{{ $info->date }}')"
                                                wire:confirm="Are you sure you want to delete all these plan?">
                                                {{ __('Delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">There is no data.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="mt-4 px-4">
                                {!! $infoState->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
