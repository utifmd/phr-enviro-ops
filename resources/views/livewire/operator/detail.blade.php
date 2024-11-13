@props(['disabled' => true])
<div class="max-w-full py-12 mx-auto sm:px-6 lg:px-8 space-y-6">
    @include('livewire.operator.tabled-card')
    @include('livewire.crew.tabled-card')
    @include('livewire.vehicle.tabled-card')
</div>
