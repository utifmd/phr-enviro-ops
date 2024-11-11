@props(['disabled' => false])

<div class="p-0 m-0">
    <textarea cols="30" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}></textarea>
</div>
