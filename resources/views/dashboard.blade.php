<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full p-5">
                    <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
                        Welcome To<br>O&M <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Environment Facilities Operations</span>
                    </h1>
                    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Hi
                        ({{ explode("_", auth()->user()->role)[1].'), '.(auth()->user()->username ?? 'NA') }}</p>
                </div>

                {{--<div class="w-full p-5">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Hi, ').(auth()->user()->username ?? 'NA') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">Welcome to O&M Environment Facilities Operations</p>
                </div>--}}
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
