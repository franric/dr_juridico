<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormaPagamentoCreateRequest extends FormRequest
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


    public function rules()
    {
        return [
            'descricao' => 'required|unique:forma_pagamentos'
        ];
    }

    public function messages()
    {
        return [
            'descricao.required'    => 'A Descrição da Forma de Pagamento é obrigatório',
            'descricao.unique'      => 'A Descrição já existe no banco de dados'
        ];
    }
}
