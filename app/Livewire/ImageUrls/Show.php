<?php

namespace App\Livewire\ImageUrls;

use App\Livewire\Forms\ImageUrlForm;
use App\Models\ImageUrl;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public ImageUrlForm $form;

    public function mount(ImageUrl $imageUrl)
    {
        $this->form->setImageUrlModel($imageUrl);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.image-url.show', ['imageUrl' => $this->form->imageUrlModel]);
    }
}
