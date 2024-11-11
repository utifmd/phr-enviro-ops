<?php

namespace App\Livewire\ImageUrls;

use App\Livewire\Forms\ImageUrlForm;
use App\Models\ImageUrl;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public ImageUrlForm $form;

    public function mount(ImageUrl $imageUrl)
    {
        $this->form->setImageUrlModel($imageUrl);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('image-urls.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.image-url.edit');
    }
}
