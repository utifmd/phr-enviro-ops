@props(['disabled' => false, 'cases' => null])

@if(!is_null($cases))
<div id="shift" class="flex flex-wrap p-4 space-x-6">
    @foreach($cases as $case)
    <div class="flex items-center">
        <input
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => (($disabled ? 'text-gray opacity-50' : '') .' w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600') ]) }}
            id="shift"
            name="shift"
            type="radio"
            value="{{ $case->value ?? $case['value'] ?? 'NA' }}">
        <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
            {{ $case->name ?? $case['name'] ?? 'NA'}}
        </label>
    </div>
    @endforeach
</div>
@endif
