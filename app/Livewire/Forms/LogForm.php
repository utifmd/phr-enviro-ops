<?php

namespace App\Livewire\Forms;

use App\Models\Log;
use Livewire\Form;

class LogForm extends Form
{
    public ?Log $logModel;

    public $event = '';
    public $highlight = '';
    public $is_opened = '';
    public $area = '';
    public $route_name = '';
    public $url = '';
    public $user_id = '';

    public function rules(): array
    {
        return [
			'event' => 'string',
			'highlight' => 'required|string',
			'is_opened' => 'required|string',
			'area' => 'required|string',
			'route_name' => 'required|string',
			'url' => 'required|string',
			'user_id' => 'required|uuid',
        ];
    }

    public function setLogModel(Log $logModel): void
    {
        $this->logModel = $logModel;

        $this->event = $this->logModel->event;
        $this->highlight = $this->logModel->highlight;
        $this->is_opened = $this->logModel->is_opened;
        $this->area = $this->logModel->area;
        $this->route_name = $this->logModel->route_name;
        $this->url = $this->logModel->url;
        $this->user_id = $this->logModel->user_id;
    }

    public function store(): void
    {
        $this->logModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->logModel->update($this->validate());

        $this->reset();
    }
}
