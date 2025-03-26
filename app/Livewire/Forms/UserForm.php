<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $userModel;

    public ?string $name;
    public ?string $email;
    public ?string $username;
    public ?string $password;
    public ?string $area_name;
    public ?string $role;
    public ?string $company_id;

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'email' => 'required|string|email',
			'username' => 'required|string|regex:/^[a-z0-9_.-]{3,27}$/',
			'area_name' => 'required|string',
			'role' => 'required|string',
			'company_id' => 'required|string',
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;

        $this->name = $this->userModel->name;
        $this->email = $this->userModel->email;
        $this->username = $this->userModel->username;
        $this->area_name = $this->userModel->area_name;
        $this->role = $this->userModel->role;
        $this->company_id = $this->userModel->company_id;
    }

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $rules = $this->rules();
        $rules['email'] = 'required|string|email|unique:users,email';
        $rules['username'] = 'required|string|unique:users,username';
        $rules['password'] = ['required', 'string', Password::default()];

        $this->userModel->create($this->validate($rules));
        $this->reset();
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $rules = $this->rules();
        if (!empty($this->password)) {
            $rules['password'] = ['required', 'string', Password::default()];
        }
        $this->userModel->update($this->validate($rules));
        $this->reset();
    }
}
