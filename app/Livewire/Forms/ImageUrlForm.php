<?php

namespace App\Livewire\Forms;

use App\Models\ImageUrl;
use Livewire\Form;

class ImageUrlForm extends Form
{
    public ?ImageUrl $imageUrlModel;
    
    public $post_id = '';

    public function rules(): array
    {
        return [
			'post_id' => 'required|string',
        ];
    }

    public function setImageUrlModel(ImageUrl $imageUrlModel): void
    {
        $this->imageUrlModel = $imageUrlModel;
        
        $this->post_id = $this->imageUrlModel->post_id;
    }

    public function store(): void
    {
        $this->imageUrlModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->imageUrlModel->update($this->validate());

        $this->reset();
    }
}
