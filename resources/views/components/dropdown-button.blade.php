@props(['label' => 'Options'])

<div class="min-w-md md:mx-2">
    <x-input-label for="options" :value="$label"/>
    <x-dropdown id="options" align="right" width="48">
        <x-slot name="trigger">
            <button {{ $attributes->merge(['class' => 'p-2.5 mt-1 bg-gray-50 text-gray-900 border border-gray-300 shadow-sm rounded-full focus:outline-none hover:opacity-50']) }}>
                <div x-data="Option" x-text="name"
                     x-on:profile-updated.window="name = $event.detail.name"></div>

                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="4"
                          d="M6 12h.01m6 0h.01m5.99 0h.01"/>
                </svg>
            </button>
        </x-slot>

        <x-slot name="content">
            {{ $slot }}
        </x-slot>
    </x-dropdown>
</div>
