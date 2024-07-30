<?php

namespace App\Http\Requests\Api\Link;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateLinkRequest extends FormRequest
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
            'link_id' => ['required'],
            'title' => ['required'],
            'icon' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],
        ];
    }

    public function messages()
    {
        return [
            'link_id.required' => trans('validation.link_id_required'),
            'title.required' => trans('validation.title_required'),
            'icon.mimes' => trans('validation.icon_mimes'),
            'icon.max' => trans('validation.icon_max'),
        ];
    }
}
