<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserInGroupRequest extends FormRequest
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
            'user_id' => ['required'],
            'group_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => trans('validation.user_id_required'),
            'group_id.required' => trans('validation.group_id_required'),
        ];
    }
}
