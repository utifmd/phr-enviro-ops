<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Trip Plan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your information is correct input, submit the form & finish this last step.') }}
        </p>
    </header>

    <form wire:submit="addTripPlan" class="mt-6 space-y-6">
        @csrf
        @include('livewire.trip-plan.form')
        <div class="flex items-center gap-4">
            <x-action-message class="me-3" on="add-trip-plan">
                {{ __('Trip plan added successfully.') }}
            </x-action-message>
        </div>
    </form>
</section>
