<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $postModel;

    public ?string $title;
    public ?string $description;
    public ?string $type;
    public ?string $status;

    public function rules(): array
    {
        return [
			'title' => 'string|nullable',
			'description' => 'string|nullable',
			'type' => 'required|string',
			'status' => 'string|nullable',
        ];
    }

    public function setPostModel(Post $postModel): void
    {
        $this->postModel = $postModel;

        $this->title = $this->postModel->title;
        $this->description = $this->postModel->description;
        $this->type = $this->postModel->type;
        $this->status = $this->postModel->status;
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
