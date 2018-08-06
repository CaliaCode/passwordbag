<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'app_logo_mini' => 'mimes:jpeg,jpg,png,gif',
            'app_logo'      => 'mimes:jpeg,jpg,png,gif',
            'theme_color'   => 'required|in:silver-brown,yellow-blu,cream-green,sun-red',
            'title'         => 'required|min:3|max:60',
            'footer_text'   => 'required|min:3|max:300'
        ];
    }
}
