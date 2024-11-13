<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $operator->name ?? __('Show') . " " . __('Operator') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        @include('livewire.operator.tabled-card')
    </div>
</div>
