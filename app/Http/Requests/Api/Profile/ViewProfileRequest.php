<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ViewProfileRequest extends FormRequest
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
            'search_profile_by' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'search_profile_by.required'  => 'Please enter uuid or id or username',
            // 'username.required_without_all' => trans('validation.username_required_without'),
            // 'card_uuid.required_without_all' => trans('validation.card_id_required_without'),
            // 'connect_id.required_without_all' => trans('validation.connect_id_required_without'),
        ];
    }

}
