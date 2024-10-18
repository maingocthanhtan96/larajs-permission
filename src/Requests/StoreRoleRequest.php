<?php

namespace LaraJS\Permission\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $role = $this->route()->parameter('role');

        return [
            'name' => ['required', 'string', Rule::unique('roles')->ignore($role)],
            'description' => 'nullable',
        ];
    }
}
