<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Detail Order') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your information is correct input, submit the form & take the next step.') }}
        </p>
    </header>

    <form wire:submit="addOrder" class="mt-6 space-y-6">
        @csrf
        @include('livewire.order.form')
        <div class="flex items-center gap-4">
            <x-action-message class="me-3" on="add-information">
                {{ __('Order added successfully.') }}
            </x-action-message>
        </div>
    </form>
</section>
