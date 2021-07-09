<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'objetoContrato' => 'required|min:10',
            'valorContrato'  => 'required|numeric',
            'valorEntradaContrato' => 'required|numeric',
            'comarcaCidadeContrato' => 'required|min:3|max:30',
            'comarcaEstadoContrato' => 'required|min:3|max:30',
            'numParcelaContrato' => 'required|numeric|digits_between:0,2',
            'dataVencContrato' => 'required|date_format:Y-m-d',
            'dataVencEntrada' => 'required|date_format:Y-m-d',

        ];
    }

    public function messages()
    {
        return [

            'objetoContrato.required'               => 'O Objeto do Contrato é obrigatório',
            'objetoContrato.min'                    => 'O Objeto do Contrato deve ter no minimo 10 caracteres',

            'valorContrato.required'                => 'O Valor do Contrato é obrigatótio',
            'valorContrato.numeric'                 => 'O Valor do Contrato deve conter apenas numeros',
            'valorContrato.digits_between'          => 'O Valor do Contrato deve conter no maximo 10 digitos',
            
            'numParcelaContrato.required'           => 'O Numero de Parcelas é obrigatótio',
            'numParcelaContrato.numeric'            => 'O Numero de Parcelas deve conter apenas numeros',
            'numParcelaContrato.digits_between'     => 'O Numero de Parcelas deve conter no maximo 2 digitos',

            'valorEntradaContrato.required'         => 'O Valor de Entrada do Contrato é obrigatótio',
            'valorEntradaContrato.numeric'          => 'O Valor de Entrada do Contrato deve conter apenas numeros',
            'valorEntradaContrato.digits_between'   => 'O Valor de Entrada do Contrato deve conter no maximo 10 digitos',

            'comarcaCidadeContrato.required'        => 'A Comarca da Cidade é obrigatório',
            'comarcaCidadeContrato.min'             => 'A Comarca da Cidade deve ter no minimo 3 caracteres',
            'comarcaCidadeContrato.max'             => 'A Comarca da Cidade deve ter no maximo 30 caracteres',

            'comarcaEstadoContrato.required'        => 'A Comarca do estado é obrigatório',
            'comarcaEstadoContrato.min'             => 'A Comarca do estado deve ter no minimo 3 caracteres',
            'comarcaEstadoContrato.max'             => 'A Comarca do estado deve ter no maximo 30 caracteres',

            'dataVencContrato.required'             => 'A Data do Vencimento é obrigatório',
            'dataVencContrato.date_format'          => 'A Data do Vencimento está no formato Inválido',

            'dataVencEntrada.required'              => 'A Data do Vencimento da Entrada é obrigatório',
            'dataVencEntrada.date_format'           => 'A Data do Vencimento da Entrada está no formato Inválido',
        ];
    }
}
