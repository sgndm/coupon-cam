<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->get('formid')){
            $x = ','.$this->get('formid');
        }else{
            $x = '';
        }
        
        return [
            'name'  =>  'required|string',
            'email'  =>  'required|email|max:255|unique:users,email'.$x,
            'password'  =>  'required|min:6|confirmed',
        ];
    }
    
    /*public function messages() {
        return [
            //'email.required' => 'Please enter valid e-mail address!',
        ];
    }*/
}
