<?php

namespace App\Http\Requests\Traits;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use Spatie\Permission\Models\Role;

/**
 * @property int $id
 */
trait HasUserInformation
{
    abstract protected function isUpdateForm(): bool;

    protected function getUserInformationRules(): array
    {
        $rules =  [
            'name' => [
                'required',
                'string',
                'max:192',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:192',
                $this->isUpdateForm()
                    ? Rule::unique(User::class)->ignore($this->id)
                    : Rule::unique(User::class),
            ],
            'dob' => [
                'date',
            ],
            'driver_license' => [
                'nullable',
                'regex:/^[a-zA-Z0-9]{10,12}$/i',
            ],
            'roles' => [
                'array',
            ],
            'roles.*' => [
                'integer',
                Rule::exists(Role::class, 'id'),
            ],
        ];

        if ( ! $this->isUpdateForm()) {
            $rules['password'] = [
                'required',
                'confirmed',
                Password::defaults(),
            ];
        }

        return $rules;
    }

}
