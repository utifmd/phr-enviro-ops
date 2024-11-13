@props(['disabled' => false])
<table class="w-full divide-y divide-gray-300">
    <thead>
    <tr>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            No
        </th>
        <th scope="col"
            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            Start From
        </th>
        <th scope="col"
            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            Finish To
        </th>
        <th scope="col"
            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            Trip Type
        </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    @foreach ($tripPlans as $plan)
        <tr class="even:bg-gray-50" wire:key="{{ $plan['no'] }}">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ $plan['no'] }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $plan['start_from'] }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $plan['finish_to'] }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $plan['trip_type'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="flex items-center mt-12 gap-4">
    <x-primary-button>Submit</x-primary-button>
</div>
