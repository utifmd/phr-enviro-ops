<table class="w-full divide-y divide-gray-300">
    <thead>
    <tr>
        <th scope="col" rowspan="2"
            class="py-4 pl-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            No
        </th>
        <th scope="col" rowspan="2"
            class="py-4 px-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            Well Number
        </th>
        <th scope="col" colspan="{{ $pivotWorkTrips['xHeaderOfDayCount'] }}"
            class="py-4 pl-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
            #Load VT in {{ date('M Y', strtotime($date)) }}
        </th>
        <th scope="col" rowspan="2"
            class="py-4 px-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
            AFE/ WBS Number
        </th>
        <th scope="col" rowspan="2"
            class="px-3 py-y text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
            Total Load
        </th>
    </tr>
    <tr>
        @for($i = 0; $i < $pivotWorkTrips['xHeaderOfDayCount']; $i++)
            <th scope="col" class="py-4 text-xs text-center font-semibold uppercase tracking-wide text-gray-500">{{ str_pad(($i + 1), 2, 0, STR_PAD_LEFT) }}</th>
        @endfor
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    @forelse($pivotWorkTrips['pivot'] as $row)
        <tr class="even:bg-gray-50" wire:key="{{ $row['wbs_number'] }}">
            <td class="whitespace-nowrap pl-4 py-4 text-sm font-semibold text-gray-900">{{ $row['numRow'].'. ' }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                <a href="#" class="hover:opacity-50">{{ $row['wellName'] }}</a>
            </td>
            @foreach($row['dailyLoadSumOfMonth'] as $day => $load)
                <td class="whitespace-nowrap py-4 text-center text-xs text-gray-500">{{ $load }}</td>
            @endforeach
            <td class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500">{{ $row['wbs_number'] }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500">{{ $row['total'] }}</td>
        </tr>
    @empty
        <tr colspan="{{ $pivotWorkTrips['xHeaderOfDayCount'] }}"></tr>
    @endforelse
        <tr>
            <td class="whitespace-nowrap px-3 py-4 text-left text-sm font-semibold text-gray-900">Grand Total</td>
            <td></td>
            @for($i = 0; $i < $pivotWorkTrips['xHeaderOfDayCount']; $i++) <td></td> @endfor
            <td></td>
            <td class="whitespace-nowrap px-3 py-4 text-center text-sm font-semibold text-gray-900">{{ $pivotWorkTrips['grandTotal'] }}</td>
        </tr>
    </tbody>
</table>
