@props(['disabled' => false])

<button type="submit" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge([
    'type' => 'submit',
    'class' => $disabled
     ? 'hover:cursor-not-allowed opacity-60 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest'
     : 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
