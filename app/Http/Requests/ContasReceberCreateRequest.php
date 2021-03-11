<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContasReceberCreateRequest extends FormRequest
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

            'valorRecebido' => 'required|numeric',
            'dataRecebimento' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [

            'valorRecebido.required'                => 'O Valor Recebido é obrigatório',
            'valorRecebido.numeric'                 => 'O Valor Recebido deve ser numérico',

            'dataRecebimento.required'              => 'A Data do Vencimento é obrigatório',
            'dataRecebimento.date_format'           => 'A Data do Vencimento está no formato Inválido',
        ];
    }
}
