<?php

use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use Livewire\Volt\Component;

new class extends Component {
    public InformationForm $form;

    /*#[\Livewire\Attributes\Session]
    public ?Information $storedInformation = null;*/
    public int $numberValue;

    public function mount(Information $information): void
    {
        /*$this->storedInformation = $this->storedInformation
            ?? Information::query()->where('post_id', '=', 1)->get()->first();*/

        $this->form->setInformationModel($information);
        $this->numberValue = 0;
    }

    public function addInformation(): void
    {
        $this->storedInformation = $this->form->store();
        $this->dispatch('add-information');
    }

    public function resetStoredInformation(): void
    {
        $this->storedInformation = null;
    }

    public function increment(): void
    {
        $this->numberValue += 1;
        $this->form->setVehicleType();
    }
}
?>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Information') }} <span wire:click="resetStoredInformation">edit</span>
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your information is correct input, submit the form & take the next step.') }}
        </p>
        <button wire:click="increment">increment ({{$numberValue}})</button>
    </header>

    <form method="POST" wire:submit="addInformation" class="mt-6 space-y-6" role="form" enctype="multipart/form-data">
        @csrf
        {{--@include('livewire.information.form', ['disabled' => $this->storedInformation])--}}
        <livewire:information.form :numberValue="$this->numberValue" />
        <div class="flex items-center gap-4">
            <x-primary-button wire:loading.attr="disabled">Save</x-primary-button>
            <x-action-message class="me-3" on="add-information">
                {{ __('Information added successfully.') }}
            </x-action-message>
        </div>
    </form>
</section>
