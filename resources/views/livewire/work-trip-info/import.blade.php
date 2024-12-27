<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Import Work Trip Info') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Import Work Trip Info') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Import Work Trip Info') }}.</p>
                    </div>
                    {{--<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none gap-1">
                        <a type="button" wire:navigate href="{{ route('well-masters.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add new</a>
                    </div>--}}
                </div>

                <div class="flow-root pt-8 space-y-4">
                    @if(session()->has('message'))
                        <div class="flex">
                            <div class="alert alert-success">
                                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                    <span class="font-medium">Complete!</span> {{ session('message') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="max-w-lg">
                        <x-input-label for="csvFile" :value="__('Upload File')"/>
                        <x-file-input accept="text/csv" wire:model="csvFile" id="csvFile" name="csvFile"/>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Import and <b>Replace</b> current CSV (MAX. 100MB).</p>
                        @error('csvFile')
                            <x-input-error class="mt-2" :messages="$message"/>
                        @enderror
                    </div>
                    <x-general-button wire:click="import" wire:loading.attr="disabled" >Import</x-general-button>
                </div>
            </div>
        </div>
    </div>
</div>
