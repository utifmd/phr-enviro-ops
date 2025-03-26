<div class="flow-root">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full py-2 align-middle">
            <div class="w-full divide-y divide-gray-300">
                <table wire:loading.class="opacity-50" class="w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No
                        </th>
                        {{--<th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time
                        </th>--}}
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Activity
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">To
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Load (Actual/Planning)
                        </th>
                        {{--<th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">VT Crew Remarks
                        </th>--}}
                    </tr>
                    </thead>
                    <tbody x-data="{tripState: @entangle('tripState'), formActValue: @entangle('form.act_value')}" class="divide-y divide-gray-200 bg-white">
                        <template x-for="(trip, i) in tripState" :key="i">
                            <tr wire:key="i" class="text-sm font-semibold even:bg-gray-50">
                            {{--<tr wire:key="i" class="text-sm font-semibold even:bg-gray-50" :class="trip.act_name !== 'Production' ? 'text-gray-500' : 'hover:bg-amber-50'">--}}
                                <td x-text="i +1" class="whitespace-nowrap py-4 pl-4 pr-3"></td>
                                {{--<td x-text="trip.time" class="whitespace-nowrap py-4 pl-4 pr-3" --}}{{--wire:click="onInfoStateTimeSelected({{$i}})"--}}{{--></td>--}}
                                <td x-text="trip.act_name+' '+trip.act_process" class="whitespace-nowrap py-4 pl-4 pr-3" {{--wire:click="onInfoStateActNameSelected({{$i}})"--}}></td>
                                <td x-text="trip.area_loc" class="whitespace-nowrap py-4 pl-4 pr-3"></td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3">
                                    <a x-text="trip.act_value+' '+trip.act_unit" x-bind:href="trip.url" class="cursor-pointer hover:underline hover:font-semibold hover:text-yellow-600"></a>
                                    {{--<span x-on:click="if(formActValue.length !== 0 && trip.act_name === 'Production') trip.act_value = formActValue+'/'+trip.act_value.split('/')[1]" x-text="trip.act_value+' '+trip.act_unit" :class="trip.act_name === 'Production' && 'cursor-pointer hover:underline hover:font-semibold hover:text-yellow-600'"></span>--}}
                                </td>
                                {{--<td x-text="trip.in_detail_remark" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>--}}
                                {{--<td class="py-4 pl-4 pr-3">
                                    <template x-for="(detail, idx) in trip.details" :key="idx">
                                        <li><a x-text="detail.remark" x-bind:href="detail.url" target="_blank" class="hover:opacity-50"></a></li>
                                    </template>
                                    --}}{{--<a x-text="trip.detail_remarks" x-bind:href="trip.in_detail_url" target="_blank" class="hover:opacity-50"></a>--}}{{--
                                </td>--}}
                            </tr>
                        </template>
                        <template x-if="!tripState.length">
                            <tr><td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Today's plans have not been set</td></tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
