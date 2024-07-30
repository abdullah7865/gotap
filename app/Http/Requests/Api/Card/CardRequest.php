<?php

namespace App\Http\Requests\Api\Card;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CardRequest extends FormRequest
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
            'card_uuid' => 'required_without_all:activation_code',
            'activation_code' => 'required_without_all:card_uuid'
        ];
    }

    // public function messages()
    // {
        
    //     return [
    //         'card_uuid.required_without_all' => 'Please enter card uuid or activation_code',
    //         'activation_code.required_without_all' => 'Please enter card uuid or activation_code',
    //     ];
    // }
    
    public function messages()
    {
        
        return [
            'card_uuid.required_without_all' => trans('validation.card_uuid_required_without'),
            'activation_code.required_without_all' => trans('validation.activation_code_required_without'),
        ];
    }
}
