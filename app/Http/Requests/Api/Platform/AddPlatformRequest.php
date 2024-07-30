<?php

namespace App\Http\Requests\Api\Platform;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddPlatformRequest extends FormRequest
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
            'platform_id' => ['required'],
            'path' => ['string'],
            'label' => ['max:25'],
            'direct' => ['in:0,1'],
        ];
    }
    
    public function messages()
    {
         return [
            'platform_id.required' => trans('validation.platform_id_required'),
            'path.string' => trans('validation.path_string'),
            'label.max' => trans('validation.label_max_length'),
        ];
    }
    
    // public function messages()
    // {
    //     return [
    //         'path.regex' => 'Please enter valid url. E.g: facebook.com, www.facebook.com, https://www.facebook.com/'
    //     ];
    // }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'errors' => $validator->errors()->all(),
    //     ], 422));
    // }
}
