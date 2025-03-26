@props(['i' => 0])
<table class="w-full divide-y divide-gray-300">
    <thead>
    <tr>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Transporter</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Driver</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Police Number</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time In</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Type</th>
        @if($type == \App\Utils\ActNameEnum::Incoming->value)
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Well Name</th>
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rig Name</th>
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Facility</th>
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">WBS Number</th>
        @elseif($type == \App\Utils\ActNameEnum::Outgoing->value)
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">From Facility</th>
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">From Pit</th>
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">To Facility</th>
        @endif
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time Out</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tds</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Volume</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Load</th>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Remarks</th>

        {{--<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>--}}
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    @forelse ($workTripDetails as $workTripDetail)
        <tr class="even:bg-gray-50" wire:key="{{ $workTripDetail->id }}">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->transporter }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->driver }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->police_number }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->time_in }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->type }}</td>
            @if($type == \App\Utils\ActNameEnum::Incoming->value)
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['well_name']}}</th>
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['rig_name']}}</th>
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['facility']}}</th>
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailIn['wbs_number']}}</th>
            @elseif($type == \App\Utils\ActNameEnum::Outgoing->value)
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['from_facility']}}</th>
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['from_pit']}}</th>
                <th class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->detailOut['to_facility']}}</th>
            @endif
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->time_out }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->tds }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->volume }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->load }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $workTripDetail->remarks }}</td>

            {{--<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                <a wire:navigate href="{{ route('post-fac.show', $workTripDetail->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                <a wire:navigate href="{{ route('post-fac.edit', $workTripDetail->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                <button
                    class="text-red-600 font-bold hover:text-red-900"
                    type="button"
                    wire:click="delete({{ $workTripDetail->id }})"
                    wire:confirm="Are you sure you want to delete?"
                >
                    {{ __('Delete') }}
                </button>
            </td>--}}
        </tr>
    @empty
        <tr>
            <td
                @if($type == \App\Utils\ActNameEnum::Incoming->value)
                    colspan="15"
                @elseif($type == \App\Utils\ActNameEnum::Outgoing->value)
                    colspan="14"
                @else
                    colspan="11"
                @endif
                class="border border-gray-300 px-4 py-2 text-center">There is no record in {{$date}}.</td>
        </tr>
    @endforelse
    </tbody>
</table>
