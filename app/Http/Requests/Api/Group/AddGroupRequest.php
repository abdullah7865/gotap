<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddGroupRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:2'],
            'active' => ['in:0,1']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('validation.title_required'),
            'title.string' => trans('validation.title_string'),
            'title.min' => trans('validation.title_min'),
            'active.in' => trans('validation.active_in'),
        ];
    }
}
