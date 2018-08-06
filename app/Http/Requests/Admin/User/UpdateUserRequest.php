<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('user');

        return [
            'id'                => 'exists:users,id',
            'name'              => 'required|max:255|unique:users,name,' . $id,
            'email'             => 'required|email|max:255|unique:users,email,' . $id,
            'status'           => 'required|boolean',
            'first_name'        => 'max:255',
            'last_name'         => 'max:255',
            'role'              => 'required|exists:roles,name',
            'projects'          => 'required_if:role,employer|array|exists:projects,id',
            'avatar'            => 'mimes:jpeg,jpg,png,gif'
            
        ];
    }
}
