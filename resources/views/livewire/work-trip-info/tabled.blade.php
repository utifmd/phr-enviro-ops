<div class="flow-root">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full py-2 align-middle">
            <div class="w-full divide-y divide-gray-300">
                <table class="w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No.
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">{{ 'Date' }}
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">{{ 'Time' }}
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">{{ 'Activity' }}
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">To
                        </th>
                        <th scope="col"
                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Quota (Planning)
                        </th>
                    </tr>
                    </thead>
                    <tbody x-data="{ infoState: @entangle('infoState'), delInfoQueue: @entangle('delInfoQueue'), formActValue: @entangle('form.act_value') }" class="divide-y divide-gray-200 bg-white">
                        <template x-for="(info, i) in infoState" :key="i">

                            <tr wire:key="i" class="even:bg-gray-50 hover:bg-amber-50">
                                <td x-text="i +1" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>
                                <td x-text="info.date" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>
                                <td x-text="info.time" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>
                                <td x-on:click="$wire.onRemoveInfoState(info); infoState.splice(i, 1);" x-text="info.act_name+' '+info.act_process" class="cursor-pointer whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 hover:line-through hover:font-semibold hover:text-red-600"></td> {{--<td wire:click="onInfoStateActNameSelected(i)" x-text="info.act_name+' '+info.act_process" class="cursor-pointer whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 hover:line-through hover:font-semibold hover:text-red-600"></td>--}}
                                <td x-text="info.area_loc" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900"></td>
                                <td x-on:click="if(formActValue.length !== 0) info.act_value = formActValue" x-text="info.act_value+' '+info.act_unit" {{--wire:click="onInfoStateValueSelected(i)"--}} class="cursor-pointer whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 hover:underline hover:font-semibold hover:text-yellow-600"></td>
                            </tr>
                        </template>
                        <template x-if="infoState.length == 0">
                            <tr><td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Server data has not been set</td></tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
