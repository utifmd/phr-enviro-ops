<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $postModel;
    
    public $title = '';
    public $description = '';
    public $type = '';

    public function rules(): array
    {
        return [
			'title' => 'string',
			'description' => 'string',
			'type' => 'required|string',
        ];
    }

    public function setPostModel(Post $postModel): void
    {
        $this->postModel = $postModel;
        
        $this->title = $this->postModel->title;
        $this->description = $this->postModel->description;
        $this->type = $this->postModel->type;
    }

    public function store(): void
    {
        $this->postModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->postModel->update($this->validate());

        $this->reset();
    }
}
