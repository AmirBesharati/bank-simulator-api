<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required' ,
                'min:4' ,
                'max:55'
            ] ,
            'account_type_id' => [
                'required' ,
                'exists:account_types,id'
            ] ,
            'balance' => [
                'gte:0'
            ]
        ];
    }
}
