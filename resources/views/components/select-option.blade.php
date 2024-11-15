@props([
    'cases' => null
])
@if(!is_null($cases))
    <select
        {!! $attributes->merge() !!}
        class="block w-full px-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 hover:opacity-50"
        name="roles" id="roles" required>
        <option value="">All</option>
        @foreach($cases as $case)
            <option value="{{ $case->value ?? $case['value'] ?? 'NA' }}">
                {{ $case->name ?? $case['name'] ?? 'NA' }}
            </option>
        @endforeach
    </select>
@else
    <x-input-error class="mt-2" messages="Undefined input parameter"/>
@endif
