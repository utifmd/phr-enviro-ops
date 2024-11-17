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
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $post->title }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Workorder Number</p>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                @include('livewire.plan-trips.confirm')
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
            @include('livewire.workorders.request.form')
        </form>
    </div>
</div>
