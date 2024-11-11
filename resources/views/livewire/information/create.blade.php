<x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }} Information
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{--<span>{{ $stepAt ? 'DONE' : '' }}</span>--}}
        </h2>
    </div>
</x-slot>

<div class="flex flex-col md:flex-row p-12 space-x-6 space-y-6">
    <div class="w-full md:w-3/12 sm:p-6 lg:p-8">
        @include('livewire.workorders.components.left-pane', [
            'steps' => $steps, 'stepAt' => \App\Models\Information::ROUTE_POS // $stepAt
        ])
    </div>
    <div class="w-full md:w-9/12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @if(session()->has('message'))
                        <div class="flex">
                            <div class="alert alert-success">
                                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                    <span class="font-medium">Success!</span> {{ session('message') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Create') }} Information</h1>
                            <p class="mt-2 text-sm text-gray-700">Add a new {{ __('Information') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            {{--<a type="button" wire:navigate href="{{ route('information.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</a>--}}
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="max-w-xl py-2 align-middle">
                                <form method="POST" wire:submit="addInformationThenNextToOrder" role="form" enctype="multipart/form-data">
                                    @csrf
                                    @include('livewire.information.form', ['disabled' => $disabled])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
