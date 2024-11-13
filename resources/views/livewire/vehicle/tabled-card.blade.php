@props([
    'disabled' => false
])
<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="w-full">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Vehicles') }}</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Vehicles') }}.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a type="button" wire:navigate href="{{ route('vehicles.create', ['operatorId' => $operator->id]) }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add new</a>
            </div>
        </div>

        <div class="flow-root">
            <div class="mt-8 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Plat</th>
                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Type</th>
                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Vendor</th>

                            @if(!$disabled)
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($vehicles as $i => $vehicle)
                            <tr class="even:bg-gray-50" wire:key="{{ $vehicle->id }}">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $vehicle->plat }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $vehicle->type }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $vehicle->vendor }}</td>

                                @if(!$disabled)
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                        <a wire:navigate href="{{ route('vehicles.show', $vehicle->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                        <a wire:navigate href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                        <button
                                            class="text-red-600 font-bold hover:text-red-900"
                                            type="button"
                                            wire:click="delete({{ $vehicle->id }})"
                                            wire:confirm="Are you sure you want to delete?"
                                        >
                                            {{ __('Delete') }}
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if(!$disabled)
                        <div class="mt-4 px-4">
                            {!! $vehicles->withQueryString()->links() !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
