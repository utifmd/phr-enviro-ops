<table class="w-full divide-y divide-gray-300">
    <thead>
        <tr>
            {{--<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>--}}
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time</th>
            @forelse($pivotWorkTrips['xHeader'] ?? [] as $i => $title)
            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs uppercase tracking-wide font-semibold {{$i % 2 !== 0 ? 'text-gray-800' : 'text-gray-500'}}">{{ $title }}</th>
            @empty
            <th colspan="13" scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">There is no data</th>
           @endforelse
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
        @foreach($pivotWorkTrips['xContent'] ?? [] as $time => $loads)
        <tr class="even:bg-gray-50 hover:bg-amber-50">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{$time}}.</td>
            @foreach($loads as $i => $load)
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 {{$i % 2 !== 0 ? 'text-gray-800 font-semibold' : 'text-gray-500'}}">{{ $load }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
