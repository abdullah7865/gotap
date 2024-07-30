<?php

namespace App\Http\Requests\Api\Link;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddLinkRequest extends FormRequest
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
            'title' => ['required'],
            'icon' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('validation.title_required'),
            'icon.mimes' => trans('validation.icon_mimes'),
            'icon.max' => trans('validation.icon_max'),
        ];
    }
}
