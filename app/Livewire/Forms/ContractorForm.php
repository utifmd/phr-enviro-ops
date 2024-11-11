<?php

namespace App\Livewire\Forms;

use App\Models\Contractor;
use Livewire\Form;

class ContractorForm extends Form
{
    public ?Contractor $contractorModel;
    
    public $name = '';
    public $prefix_name = '';
    public $suffix_name = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'prefix_name' => 'string',
			'suffix_name' => 'string',
        ];
    }

    public function setContractorModel(Contractor $contractorModel): void
    {
        $this->contractorModel = $contractorModel;
        
        $this->name = $this->contractorModel->name;
        $this->prefix_name = $this->contractorModel->prefix_name;
        $this->suffix_name = $this->contractorModel->suffix_name;
    }

    public function store(): void
    {
        $this->contractorModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->contractorModel->update($this->validate());

        $this->reset();
    }
}
