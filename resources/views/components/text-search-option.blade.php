@props(['disabled' => false])
<div class="py-1">
    <div x-data="{ open: false }" @click.away="open = false" class="relative">
        <input
            {{ $disabled ? 'disabled' : '' }}
            @focus="open = true"
            @keydown.escape="open = false"
            {!! $attributes->merge(['class' => 'block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm '.($disabled ? 'opacity-60' : '')]) !!}
            type="text"
            placeholder="Pick Up From"/>
        <div x-show="open" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
            <ul class="py-1 text-gray-700">
                {{ $slot }}
            </ul>
        </div>
    </div>
</div>
