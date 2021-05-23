<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormaPagamentoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descricao' => 'required|min:4|max:50|unique:forma_pagamentos,descricao,' .$this->id,
        ];
    }

    public function messages()
    {
        return [
            'descricao.required'    => 'A Descrição é Obrigatorio',
            'descricao.unique'      => 'A Descrição já existe no banco de dados',
        ];
    }
}
