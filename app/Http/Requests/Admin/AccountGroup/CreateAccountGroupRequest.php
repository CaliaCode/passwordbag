<?php

namespace App\Http\Requests\Admin\AccountGroup;

// Framework
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAccountGroupRequest extends FormRequest
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
            'id'                    => 'exists:account_groups,id',
            'title'                 => 'required|max:255',
            'category'              => 'numeric|exists:categories,id',
            'project'               => 'exists:projects,id',
            'accounts'              => 'required',
            'accounts.*.id'         => [Rule::exists('accounts', 'id')->where(function($query){
                $data = $this->validationData();
                
                $query->where('account_group_id', $data['id']);
            })],
            'accounts.*.name'       => 'required|min:3|max:255',
            'accounts.*.value'      => 'required|min:3|max:255',
            'accounts.*.value_type' => 'required|min:3|max:255|in:text,textarea,email,password,link'
        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $v = parent::getValidatorInstance();
        
        foreach($this->all()['accounts'] as $key => $account){
            $v->sometimes('accounts.' . $key . '.value', 'email', function ($input) use($key) {                
                return $input['accounts'][$key]['value_type'] == 'email';                
            });

            $v->sometimes('accounts.' . $key . '.value', 'url', function ($input) use($key) {                
                return $input['accounts'][$key]['value_type'] == 'link';                
            });
        }
        
        return $v;
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'            => 'Title is required.',
            'title.max'                 => 'Title can be at maximum 255 character.',
            'accounts.required'         => 'Account information\'s are required.',
            'accounts.*.name.required'  => 'Name is required.',
            'accounts.*.name.min'       => 'Name can be at minimum 3 character.',
            'accounts.*.name.max'       => 'Name can be at maximum 255 character.',
            'accounts.*.value.required' => 'Value is required.',
            'accounts.*.value.min'      => 'Value can be at minimum 3 character.',
            'accounts.*.value.max'      => 'Value can be at maximum 255 character.',
            'accounts.*.value.email'    => 'Value must be a valid Email Address.',
            'accounts.*.value.url'      => 'Value must be a valid Url.',
        ];
    }
}
