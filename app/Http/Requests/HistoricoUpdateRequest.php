<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricoUpdateRequest extends FormRequest
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
            'historico' => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'historico.required' => 'O Texto do Histórico e Obrigatório',
            'historico.min' => 'O Histórico deve ter no minimo 10 caracteres'
        ];
    }
}
