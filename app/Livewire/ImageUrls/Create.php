<?php

namespace App\Livewire\ImageUrls;

use App\Livewire\Forms\ImageUrlForm;
use App\Models\ImageUrl;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public ImageUrlForm $form;

    public function mount(ImageUrl $imageUrl)
    {
        $this->form->setImageUrlModel($imageUrl);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('image-urls.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.image-url.create');
    }
}
