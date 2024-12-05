<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create') }} Work Trip Info
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">

                @if(session()->has('message'))
                    <div class="flex">
                        <div class="alert alert-success">
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                 role="alert">
                                <span class="font-medium">Notification!</span> {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Quota Penerimaan Area {{ $authUsr['area_name'] ?? 'NA' }}</h1>
                        <p class="mt-2 text-sm text-gray-700">{{$isEditMode ? 'Change' : 'Set'}} Quota Penerimaan.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('work-trip-infos.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">All Planning</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="max-w-screen-xl py-2 align-middle">
                            <form method="POST" wire:submit="save" role="form" enctype="multipart/form-data">
                                @csrf
                                @include('livewire.work-trip-info.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
