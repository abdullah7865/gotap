<?php

namespace App\Http\Requests\Api\Platform;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IncrementRequest extends FormRequest
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
            'platform_id' => ['required']
        ];
    }
    
    public function messages()
    {
        return [
            'user_id.required' => trans('validation.user_id_required'),
            'platform_id.required' => trans('validation.platform_id_required'),
        ];
    }
}
