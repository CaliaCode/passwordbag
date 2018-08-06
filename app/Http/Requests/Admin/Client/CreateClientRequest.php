<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
        return [
            'company'           => 'required|min:3|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|min:3|max:255',
            'mobile'            => 'max:255',
            'website'           => 'url|max:255',
            'vat_number'        => 'max:255',
            'country'           => 'max:255',
            'province'          => 'max:255',
            'address'           => 'max:255',
            'zip_code'          => 'max:255'
        ];
    }
}
