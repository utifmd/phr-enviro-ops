@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full px-4 py-2.5 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm '.($disabled ? 'opacity-60 bg-gray-200' : '')]) !!}>
