<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Request') }} Trip
    </h2>
</x-slot>
@props(['noAction' => true, 'disabled' => false])
<div class="flex flex-col md:flex-row p-12 space-x-6 space-y-6">
    <div class="w-full md:w-5/12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="w-full grid grid-cols-3 gap-2 justify-end">
                        {{--<div>
                            <x-input-label for="schedule" value="{{ 'Schedule' }}"/>
                            <x-radio-button
                                :cases="\App\Utils\WorkTripScheduleEnum::cases()"
                                wire:model="schedule"
                                id="schedule" name="schedule" disabled="true"/>
                            @error('schedule')
                            <x-input-error class="mt-2" :messages="$message"/>
                            @enderror
                        </div>--}}
                        <div>
                            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Info Location:</h2>
                            <ul class="space-y-4 text-left text-gray-500 dark:text-gray-400">
                                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400"
                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                    </svg>
                                    <span>Location to <span
                                                class="font-semibold text-gray-900 dark:text-white">GS/CGS</span></span>
                                </li>
                                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <span class="px-7">TDS < 4000 COD < 300 & Memenuhi 8 Baku Mutu Parameter</span>
                                </li>
                                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400"
                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                    </svg>
                                    <span>Location to <span
                                                class="font-semibold text-gray-900 dark:text-white">CMTF</span></span>
                                </li>
                                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <span class="px-7">TDS > 10.000</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Info Quota
                                Penerimaan:</h2>
                            <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                                <li class="flex items-center">
                                    <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                         viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    Hari Ini&nbsp;<span class="font-semibold text-gray-900 dark:text-white">15-5</span>&nbsp;Load
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                         viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    Besok&nbsp;<span class="font-semibold text-gray-900 dark:text-white">18-2</span>&nbsp;Load
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if(session()->has('message'))
                        <div class="flex">
                            <div class="alert alert-success">
                                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                     role="alert">
                                    <span class="font-medium">Complete!</span> {{ session('message') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ 'post->title' }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Work Trip Number</p>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                @include('livewire.post-fac-report.request.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full md:w-7/12">
        <form method="POST" wire:submit="onSubmit" role="form" enctype="multipart/form-data">
            @csrf
            @include('livewire.post-fac-report.request.form')
        </form>
    </div>
</div>
