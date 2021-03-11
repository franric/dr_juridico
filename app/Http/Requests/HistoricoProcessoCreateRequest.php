<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricoProcessoCreateRequest extends FormRequest
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
            'titulo'        => 'required|min:10|max:100',
            'tarefa'        => 'required|min:10|max:100',
            'dataTarefa'    => 'required|date_format:Y-m-d',
            'horaTarefa'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required'           => 'O Título é Obrigatório',
            'titulo.min'                => 'O Título deve conter no minimo 10 caracteres',
            'titulo.max'                => 'O Título deve conter no máximo 100 caracteres',

            'tarefa.required'           => 'A Tarefa é Obrigatório',
            'tarefa.min'                => 'A Tarefa deve conter no minimo 10 caracteres',
            'tarefa.max'                => 'A Tarefa deve conter no máximo 100 caracteres',

            'dataTarefa.required'       => 'A Data é Obrigatória',
            'dataTarefa.date_format'    => 'O Formato da data é inválido',

            'horaTarefa.required'       => 'A Hora e Obrigatória'
        ];
    }
}
