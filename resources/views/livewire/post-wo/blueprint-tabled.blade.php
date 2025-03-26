<div class="flow-root">
    <div class="flex flex-col md:flex-row justify-between">
        <div>
            <table class="mt-8 py-2">
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">WO Number</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$generatedWoNumber}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Operator</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->operator->short_name}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Vehicle Type</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->vehicle_type}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Vehicle Number</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->vehicle->plat}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Driver Name</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->crew->name}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Start Plan</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->start_plan}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">End Plan</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->end_plan}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Shift</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->shift}}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 text-sm font-semibold text-gray-900">Area</td>
                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">:</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{$information->area}}</td>
                </tr>
            </table>
        </div>
        <div class="mt-6 p-4">
            @if(isset($qrBase64Data))
                <img src="data:image/png;base64,{{ $qrBase64Data }}" alt="barcode"/>
            @elseif(!is_null($url = $postForm->postModel->imageUrl->url ?? null))
                <img src="{{ $url }}" alt="barcode"/>
            @endif
        </div>
    </div>
    <div class="mt-8 overflow-x-auto">
        <div class="inline-block min-w-full py-2 align-middle">
            <div class="w-full divide-y divide-gray-300">
                <table>
                    <thead class="bg-yellow-100">
                    <tr>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            No
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Status
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Description
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Req Qty
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Rem Qty
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Sch Qty
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Uom
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Required Date
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Pick Up From
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Destination
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Wr Number
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Rig Name
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Pic
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Charge
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr class="even:bg-gray-50">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">1.</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->status}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->description}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->req_qty}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->rem_qty}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->sch_qty}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->uom}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->required_date}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->pick_up_from}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->destination}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->wr_number}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->rig_name}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->pic}}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$planOrder->charge}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-8 overflow-x-auto">
        <div class="inline-block min-w-full py-2 align-middle">
            <div class="w-full divide-y divide-gray-300">
                <table>
                    <thead class="bg-green-100">
                    <tr>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            No.
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
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Actual Start
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Actual Finish
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Km Start
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Km End
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Km Actual
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Km Contract
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Start Working Date
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            End Working Date
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Total Standby Hour
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Total Working Hour
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($planTrips as $i => $trip)
                        <tr class="even:bg-gray-50">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{$i +1}}
                                .
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->start_from}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->finish_to}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->trip_type}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->actual_start}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->actual_finish}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->km_start}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->km_end}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->km_actual}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->km_contract}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->start_working_date}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->end_working_date}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->total_standby_hour}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$trip->total_working_hour}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
