<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $userModel;

    public ?string $name;
    public ?string $email;
    public ?string $username;
    public ?string $password;
    public ?string $role;
    public ?string $operator_id;

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'email' => 'required|string|email',
			'username' => 'required|string|regex:/^[a-z0-9_.-]{3,15}$/',
			'role' => 'required|string',
			'operator_id' => 'required|string',
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;

        $this->name = $this->userModel->name;
        $this->email = $this->userModel->email;
        $this->username = $this->userModel->username;
        $this->role = $this->userModel->role;
        $this->operator_id = $this->userModel->operator_id;
    }

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $rules = $this->rules();
        $rules['email'] = 'required|string|email|unique:users,email';
        $rules['username'] = 'required|string|unique:users,username';
        $this->userModel->create($this->validate($rules));

        $this->reset();
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->userModel->update($this->validate());

        $this->reset();
    }
}
