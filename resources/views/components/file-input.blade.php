@props(['disabled' => false])

<div class="relative inline-block">
    <input type="file"
        {{ $disabled ? 'disabled' : '' }}
        {!!
            $attributes->merge(
                [
                    'class' => 'py-2 px-3 file:text-sm file:cursor-pointer border-gray-300 file:absolute file:right-2 file:top-1.5 file:bg-blue-500 file:text-white file:border-0 file:py-1 file:px-3 file:rounded-full'.($disabled ? 'opacity-60' : '')
                ]
            )
        !!}>
</div>
