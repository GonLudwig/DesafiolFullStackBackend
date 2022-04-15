<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnpjRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cnpj' => 'required|min:14|max:18'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cnpj.required' => 'O campo cnpj e obrigatorio.',
            'cnpj.min' => 'O campo deve possuir no minimo 14 digitos.',
            'cnpj.max' => 'O campo deve possuir no maximo 18 digitos.'
        ];
    }    
}