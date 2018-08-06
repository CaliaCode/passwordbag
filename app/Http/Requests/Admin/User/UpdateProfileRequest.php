<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('user');
        
        return Gate::allows('update-profile', $id);
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
            'name'         => 'required|max:255|unique:users,name,' . $id,
            'email'        => 'required|email|max:255|unique:users,email,' . $id,
            'first_name'   => 'max:255',
            'last_name'    => 'max:255',
            'avatar'       => 'mimes:jpeg,jpg,png,gif'
        ];
    }
}
