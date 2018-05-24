<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPanelRequest extends FormRequest
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
            'name'  =>  'required|string',
            'first_name'  =>  'required|string',
            'last_name'  =>  'required|string',
            'formid'  =>  'required|email|max:255|unique:users,email,'.$this->get('formid').',email',
        ];
    }
}
