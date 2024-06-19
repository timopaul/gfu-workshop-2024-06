<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasUserInformation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Spatie\Permission\Models\Role;

/**
 * @property int $id
 */
class UserUpdateRequest extends FormRequest
{
    use HasUserInformation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = auth()->user();
        return $user->hasAnyPermission('edit-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->getUserInformationRules();
    }

    protected function isUpdateForm(): bool
    {
        return true;
    }
}
