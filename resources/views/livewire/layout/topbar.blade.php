<?php

use App\Livewire\Actions\Logout;
use App\Repositories\Contracts\IUserRepository;
use Livewire\Volt\Component;

new class extends Component {
    public array $authUsr;
    /**
     * Log the current user out of the application.
     */
    public function mount(IUserRepository $usrRepos): void
    {
        $this->authUsr = $usrRepos->authenticatedUser()->toArray();
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
@props([
    'areaName' => ucfirst(strtolower($authUsr['area_name'] ?? 'NA')),
    'username' => $authUsr['username'] ?? 'NA'
])
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{--<div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        {{ config('app.name', 'PHR Environment') }}
                    </a>
                </div>--}}
            </div>

            <!-- Notification Button & Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <sup>({{ $areaName }})</sup>&nbsp;
                            <div x-data="{{ json_encode(['name' => $username ]) }}" x-text="name"
                                 x-on:profile-updated.window="name = $event.detail.name">
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Home') }}
            </x-responsive-nav-link>

            {{--@can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW)
                <x-responsive-nav-link :href="route('post-fac-in.index')"
                                       :active="request()->routeIs('post-fac-in.*')" wire:navigate>
                    Facility Incoming
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-out.index')"
                                       :active="request()->routeIs('post-fac-out.*')" wire:navigate>
                    Facility Outgoing
                </x-responsive-nav-link>
            @endcan--}}
            @can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW)
                <x-responsive-nav-link :href="route('post-fac-in.index')"
                                       :active="request()->routeIs('post-fac-in.*')" wire:navigate>
                    Incoming
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-out.index')"
                                       :active="request()->routeIs('post-fac-out.*')" wire:navigate>
                    Outgoing
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-prod.index')"
                                       :active="request()->routeIs('post-fac-prod.*')" wire:navigate>
                    Production
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-report.summary')" :active="request()->routeIs('post-fac-report.*')"
                                       wire:navigate>
                    Summary
                </x-responsive-nav-link>
                {{--<x-responsive-nav-link :href="route('post-fac-report.index')" :active="request()->routeIs('post-fac-report.*')"
                                       wire:navigate>
                    In/Out Actual
                </x-responsive-nav-link>--}}
            @endcan

            @can(\App\Policies\UserPolicy::IS_NOT_GUEST_ROLE)
                <x-responsive-nav-link :href="route('well-masters.index')"
                                       :active="request()->routeIs('well-masters.*')" wire:navigate>
                    {{ __('Well Master') }}
                </x-responsive-nav-link>
            @endcan

            @can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP)
                <x-responsive-nav-link :href="route('post-fac-threshold.index')"
                                       :active="request()->routeIs('post-fac-threshold.*')" wire:navigate>
                    In/Out Planing
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac.index')"
                                       :active="request()->routeIs('post-fac.index')" wire:navigate>
                    In/Out Log Sheet
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-report.requests.index')"
                                       :active="request()->routeIs('post-fac-report.requests.*')" wire:navigate>
                    Ops Verification
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac.report')"
                                       :active="request()->routeIs('post-fac.report')" wire:navigate>
                    Facility Monthly Report
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-report.report')"
                                       :active="request()->routeIs('post-fac-report.report')" wire:navigate>
                    Facility Daily Report
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-report.operational-report')"
                                       :active="request()->routeIs('post-fac-report.operational-report')" wire:navigate>
                    Ops Report
                </x-responsive-nav-link>
            @endcan
            @can(\App\Policies\UserPolicy::IS_DEV_ROLE)

                <x-responsive-nav-link :href="route('teams.index')" :active="request()->routeIs('teams.*')" wire:navigate>
                    Team
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" wire:navigate>
                    Company
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('man-power.index')" :active="request()->routeIs('man-power.*')" wire:navigate>
                    Man Power
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" wire:navigate>
                    User
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('areas.index')" :active="request()->routeIs('areas.*')" wire:navigate>
                    Area
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.*')" wire:navigate>
                    Activity
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('vehicles.index')" :active="request()->routeIs('vehicles.*')" wire:navigate>
                    Equipment
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.*')"
                                       wire:navigate>
                    {{ __('Event') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('well-masters.import')" :active="request()->routeIs('vehicles.*')" wire:navigate>
                    Import Well Master
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-threshold.import')" :active="request()->routeIs('vehicles.*')" wire:navigate>
                    Import Facility In/Out Planing
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('post-fac-report.import')" :active="request()->routeIs('vehicles.*')" wire:navigate>
                    Import Facility In/Out Actual
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800"
                     x-data="{{ json_encode(['name' => $username]) }}"
                     x-text="name"
                     x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ $username }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{--<div class="relative w-56 h-56 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                        <span class="bg-blue-200 text-xs font-medium text-blue-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-blue-200 absolute -translate-y-1/2 -translate-x-1/2 right-auto top-0 left-0">top-left</span>
                    </div>--}}
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
