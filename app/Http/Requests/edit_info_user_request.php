<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class edit_info_user_request extends FormRequest
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
            'name'           =>  'required',
            'email'          =>  'required|email',
            'mobile'         =>  'required|numeric|unique:users,mobile',
            'bio'            =>  'nullable|min:10',
            'receive_email'  =>  'required',
            'user_image'     =>  'nullable|image|max:20000,mimes:jpg,jpeg.png',
        ];
    }
}
