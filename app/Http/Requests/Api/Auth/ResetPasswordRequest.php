<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:50'],
            'otp' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.email_required'),
            'email.email' => trans('validation.email'),
            'email.max' => trans('validation.email_max'),
            'otp.required' => trans('validation.otp_required'),
            'password.required' => trans('validation.password_required'),
            'password.min' => trans('validation.password_min'),
            'password.confirmed' => trans('validation.password_confirmed'),
        ];
    }
}
