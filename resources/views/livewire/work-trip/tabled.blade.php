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
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Time
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Activity
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Well Name
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">To
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Load (Actual/Planning)
                        </th>
                    </tr>
                    </thead>
                    <tbody x-data="{tripState: @entangle('tripState'), formActValue: @entangle('form.act_value'), wellState: wellState}" class="divide-y divide-gray-200 bg-white">
                        <template x-for="(trip, i) in tripState" :key="i">
                            <tr wire:key="i" class="even:bg-gray-50 hover:bg-amber-50">
                                <td x-text="i +1" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>
                                <td x-text="trip.time" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900" {{--wire:click="onInfoStateTimeSelected({{$i}})"--}}></td>
                                <td x-text="trip.act_name+' '+trip.act_process" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900" {{--wire:click="onInfoStateActNameSelected({{$i}})"--}}></td>
                                <td>
                                    <div x-show="trip.act_process == 'Mud Pit Closure' && wellState.mudPit.length">
                                        <template x-for="(item, j) in wellState.mudPit" :key="j">
                                            <x-text-badge-with-close-button x-text="item" class="my-1 mx-1"/>
                                        </template>
                                    </div>
                                    <div x-show="trip.act_process == 'Drilling Site'">
                                        <template x-for="(item, j) in wellState.drilling" :key="j">
                                            <x-text-badge-with-close-button x-text="item" class="my-1 mx-1"/>
                                        </template>
                                    </div>
                                </td>
                                <td x-text="trip.area_loc" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>
                                <td x-on:click="if(formActValue.length !== 0) trip.act_value = formActValue+'/'+trip.act_value.split('/')[1]" x-text="trip.act_value+' '+trip.act_unit" {{--wire:click="onInfoStateValueSelected(i)"--}} class="cursor-pointer whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 hover:underline hover:font-semibold hover:text-yellow-600"></td>
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
