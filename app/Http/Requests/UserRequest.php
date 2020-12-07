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
            'name'                  => "required|min:3|max:16|regex:/^[A-Za-z][A-Za-z0-9]{2,16}$/|unique:users,name,{$this->user->id}",
            'email'                 => 'required|email|max:255',
            'password'              => 'nullable|bail|required_with:password_confirmation|min:6|confirmed',
            'password_confirmation' => 'nullable|bail|required_with:password|min:6',
            'first_name'            => 'nullable|min:3|max:30|name',
            'last_name'             => 'nullable|min:3|max:30|name',
        ];
    }

    public function messages()
    {
        return [
            "name.regex" => "Полето за :attribute може да съдържа само латински букви и цифри, като първият символ трябва да бъде буква",
            "first_name.regex" => "Полето за :attribute може да съдържа само символи на кирилица и интервал",
            "last_name.regex"  => "Полето за :attribute може да съдържа само символи на кирилица и интервал",
        ];
    }
}
