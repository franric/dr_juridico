<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceitaCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descricao' => 'required|min:4|max:50|unique:receitas',
            'valor'     => 'required|digits_between:1,10'
        ];
    }

    public function messages()
    {
        return [
            'descricao.required'    => 'A Descrição é Obrigatorio',
            'descricao.unique'      => 'A Descrição já existe no banco de dados',
            'descricao.min'         => 'A Descrição deve conter no minimo 4 caracteres',
            'descricao.max'         => 'A Descrição deve conter no maximo 50 caracteres',

            'valor.required'        => 'O Valor é Obrigatorio',
            'valor.digits_between'  => 'A Valor deve conter no minimo 1 e 10 digitos',
        ];
    }
}
