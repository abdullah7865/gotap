<?php

namespace App\Http\Requests\Api\PhoneContact;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddPhoneContactRequest extends FormRequest
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
            'first_name' => ['required', 'min:2', 'max:30'],
            'last_name'  => ['nullable', 'min:2', 'max:30'],
            'email'      => ['nullable', 'email'],
            'work_email' => ['nullable', 'email'],
            'company_name' => ['nullable', 'min:3', 'max:20'],
            'job_title'  => ['nullable', 'max:50'],
            'address'       => ['nullable', 'min:3', 'max:110'],
            'phone'      => ['required', 'min:5', 'max:15'],
            'work_phone' => ['nullable', 'min:5', 'max:15'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],

        ];
    }

   public function messages()
    {
        return [
            'first_name.required' => trans('validation.first_name_required'),
            'first_name.min' => trans('validation.first_name_min'),
            'first_name.max' => trans('validation.first_name_max'),
            'last_name.min'  => trans('validation.last_name_min'),
            'last_name.max'  => trans('validation.last_name_max'),
            'email.email'      => trans('validation.email'),
            'email.max'      => trans('validation.email_max'),
            'work_email.email' => trans('validation.work_email_email'),
            'work_email.max' => trans('validation.work_email_max'),
            'company_name.min' => trans('validation.company_name_min'),
            'company_name.max' => trans('validation.company_name_max'),
            'job_title.max'  => trans('validation.job_title_max'),
            'address.min'       => trans('validation.address_min'),
            'address.max'       => trans('validation.address_max'),
            'phone.required'      =>trans('validation.phone_required'),
            'phone.min'      => trans('validation.phone_min'),
            'phone.max'      => trans('validation.phone_max'),
            'work_phone.min' => trans('validation.work_phone_min'),
            'work_phone.max' => trans('validation.work_phone_max'),
            'photo.mimes' => trans('validation.photo_mimes'),
            'photo.max' => trans('validation.photo_max'),

        ];
    }
}
