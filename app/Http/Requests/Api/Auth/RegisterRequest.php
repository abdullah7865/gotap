<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'max:20'],
            'username' => ['required', 'min:5', 'max:25', 'regex:/^[A-Za-z][A-Za-z0-9_.]{5,25}$/', 'unique:users'],
            'email' => ['required', 'email', 'max:50', 'unique:users'],
            'phone' => ['sometimes', 'min:5', 'max:15', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }

    // public function messages()
    // {
    //     return [
    //       'username.regex' => 'The username must start with a letter and can only contain letters (uppercase or lowercase), numbers, underscores, or periods. It should be between 5 and 25 characters long.',
    //     ];
    // }
    
    public function messages()
    {
        return [
            'name.required' => trans('validation.name_required'),
            'name.min' => trans('validation.name_min'),
            'name.max' => trans('validation.name_max'),
            
            'username.required' => trans('validation.username_required'),
            'username.min' => trans('validation.username_min'),
            'username.max' => trans('validation.username_max'),
            'username.regex' => trans('validation.username_regex'),
            'username.unique' => trans('validation.username_unique'),
            'email.required' => trans('validation.email_required'),
            'email.email' => trans('validation.email'),
            'email.unique' => trans('validation.email_unique'),
            'phone.min' => trans('validation.phone_min'),
            'phone.max' => trans('validation.phone_max'),
            'phone.unique' => trans('validation.phone_unique'),
            'password.required' => trans('validation.password_required'),
            'password.min' => trans('validation.password_min'),
            'password.confirmed' => trans('validation.confiremd'),
        ];
    }
    
    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'errors' => $validator->errors()->all(),
    //     ], 422));
    // }
}
