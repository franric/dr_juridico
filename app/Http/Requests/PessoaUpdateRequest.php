<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaUpdateRequest extends FormRequest
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
        if ($this->get("tipoPessoa") == 1) {

            return [

                'nomeRazaoSocial' => 'required|min:6|max:100',
                'cpfCnpj'  => 'required|numeric|digits_between:11,18|unique:pessoas,cpfCnpj,' . $this->pessoa,
                'logradouro' => 'required|min:4|max:50',
                'numero' => 'required|numeric|digits_between:1,4',
                'bairro' => 'required|min:4|max:30',
                'estado' => 'required|min:4|max:20',
                'cidade' => 'required|min:4|max:30',
                'celUm' => 'required|numeric|digits_between:11,11',

                'nacionalidade' => 'nullable|min:4|max:30',
                'estadoCivil' => 'nullable|min:4|max:30',
                'profissao' => 'nullable|min:4|max:30',
                'rg' => 'nullable|min:4|max:10',
                'ctps' => 'nullable|min:4|max:15',
                'email' => 'nullable|min:10|max:50',
                'orgExpedidor' => 'nullable|min:2|max:10',
                'ufOrgExpedidor' => 'nullable|min:2|max:2',
            ];

        } else if($this->get("tipoPessoa") == 2){

            return [

                'nomeRazaoSocial' => 'required|min:6|max:100',
                'cpfCnpj'  => 'required|numeric|digits_between:11,18|unique:pessoas,cpfCnpj,' . $this->pessoa,
                'logradouro' => 'required|min:4|max:50',
                'numero' => 'required|numeric|digits_between:1,4',
                'bairro' => 'required|min:4|max:30',
                'estado' => 'required|min:4|max:20',
                'cidade' => 'required|min:4|max:30',
                'celUm' => 'required|numeric|digits_between:11,11',

                'nire'                          => 'nullable|numeric|digits_between:4,10',
                'inscEstatual'                  => 'nullable|min:4|max:15',
                'inscMunicipal'                 => 'nullable|min:4|max:15',
                'nomeRepresentante'             => 'required|min:6|max:100',
                'nacionalidadeRepresentante'    => 'nullable|min:4|max:30',
                'estadoCivilRepresentante'      => 'nullable|min:6|max:30',
                'profissaoRepresentante'        => 'nullable|min:6|max:50',
                'rgRepresentante'               => 'nullable|min:3|max:10',
                'cpfRepresentante'              => 'required|numeric|digits_between:11,11',
                'ctpsRepresentante'             => 'nullable|min:2|max:15',
                'emailRepresentante'            => 'nullable|min:11|max:50',
                'orgExpedidorRepresentante'     => 'nullable|min:2|max:10',
                'ufOrgExpedidorRepresentante'   => 'nullable|min:2|max:2',
                'logradouroRepresentante'       => 'required|min:3|max:50',
                'numeroRepresentante'           => 'required|numeric|digits_between:1,5',
                'complementoRepresentante'      => 'nullable|min:4|max:50',
                'bairroRepresentante'           => 'required|min:5|max:30',
                'cidadeRepresentante'           => 'required|min:4|max:30',
                'estadoRepresentante'           => 'required|min:4|max:20',

            ];
        }
    }

    public function messages()
    {
        return [

            'nomeRazaoSocial.required' => 'O Nome é obrigatório',
            'nomeRazaoSocial.min'      => 'O Nome deve ter no minimo 6 caracteres',
            'nomeRazaoSocial.max'      => 'O Nome deve ter no maximo 100 caracteres',

            'logradouro.required'      => 'O Logradouro é obrigatório',
            'logradouro.min'           => 'O Logradouro deve ter no minimo 4 caracteres',
            'logradouro.max'           => 'O Logradouro deve ter no maximo 50 caracteres',

            'cpfCnpj.required'          => 'O CPF/CNPJ é obrigatótio',
            'cpfCnpj.numeric'          => 'O CP/FCNPJ deve conter apenas numeros',
            'cpfCnpj.digits_between'   => 'O CPF/CNPJ deve conter 18 digitos',
            'cpfCnpj.unique'           => 'O CPF/CNPJ já existe no Banco de Dados',

            'numero.required'          => 'O Numero é obrigatótio',
            'numero.numeric'          => 'O Numero deve conter apenas numeros',
            'numero.digits_between'   => 'O Numero deve conter de 1 a 4 digitos',

            'bairro.required'      => 'O Bairro é obrigatório',
            'bairro.min'           => 'O Bairro deve ter no minimo 4 caracteres',
            'bairro.max'           => 'O Bairro deve ter no maximo 30 caracteres',

            'estado.required'      => 'O Estado é obrigatório',
            'estado.min'           => 'O Estado deve ter no minimo 4 caracteres',
            'estado.max'           => 'O Estado deve ter no maximo 20 caracteres',

            'cidade.required'      => 'A Cidade é obrigatório',
            'cidade.min'           => 'A Cidade deve ter no minimo 4 caracteres',
            'cidade.max'           => 'A Cidade deve ter no maximo 30 caracteres',

            'celUm.required'          => 'O Celular 1 é obrigatótio',
            'celUm.numeric'          => 'O Celular 1 deve conter apenas numeros',
            'celUm.digits_between'   => 'O Celular 1 deve conter 11 digitos',

            'nacionalidade.min'      => 'A Nacionalidade deve ter no minimo 4 caracteres',
            'nacionalidade.max'      => 'A Nacionalidade deve ter no maximo 30 caracteres',

            'estadoCivil.min'      => 'O Estado Civil deve ter no minimo 4 caracteres',
            'estadoCivil.max'      => 'O Estado Civil deve ter no maximo 30 caracteres',

            'profissao.min'      => 'A Profissão deve ter no minimo 4 caracteres',
            'profissao.max'      => 'A Profissão deve ter no maximo 30 caracteres',

            'rg.min'      => 'O RG deve ter no minimo 4 caracteres',
            'rg.max'      => 'O RG deve ter no maximo 10 caracteres',

            'ctps.min'      => 'O CTPS deve ter no minimo 4 caracteres',
            'ctps.max'      => 'O CTPS deve ter no maximo 15 caracteres',

            'email.min'      => 'O EMAIL deve ter no minimo 10 caracteres',
            'email.max'      => 'O EMAIL deve ter no maximo 50 caracteres',

            'orgExpedidor.min'      => 'O Orgão Expedidor deve ter no minimo 2 caracteres',
            'orgExpedidor.max'      => 'O Orgão Expedidor deve ter no maximo 10 caracteres',

            'ufOrgExpedidor.min'      => 'A UF Orgão Expedidor deve ter no minimo 2 caracteres',
            'ufOrgExpedidor.max'      => 'A UF Orgão Expedidor deve ter no maximo 2 caracteres',

            'nire'                          => 'A NIRE deve conter apenas numeros',
            'nire'                          => 'A NIRE deve conter de 4 a 11 digitos',

            'inscEstatual.min'                  => 'A Inscrição Estadual deve conter no minimo 4 caracteres',
            'inscEstatual.max'                  => 'A Inscrição Estadual deve conter no maximo 15 caracteres',

            'inscMunicipal.min'                 => 'A Inscrição Municipal deve conter no minimo 4 caracteres',
            'inscMunicipal.max'                 => 'A Inscrição Municipal deve conter no maximo 15 caracteres',

            'nomeRepresentante.required'        => 'O nome do Representante e Obrigatório',
            'nomeRepresentante.min'             => 'O Nome do Representante deve conter no minimo 6 caracteres',
            'nomeRepresentante.max'             => 'O Nome do Representante deve conter no maximo 100 caracteres',

            'nacionalidadeRepresentante.min'    => 'A Nacionalidade do Representante deve conter no minimo 4 caracteres',
            'nacionalidadeRepresentante.max'    => 'A Nacionalidade do Representante deve conter no maximo 30 caracteres',

            'estadoCivilRepresentante.min'      => 'O Estado Civil do Representante deve conter no minimo 6 caracteres',
            'estadoCivilRepresentante.max'      => 'O Estado Civil do Representante deve conter no maximo 30 caracteres',

            'profissaoRepresentante.min'        => 'A Profissão do Representante deve conter no minimo 4 caracteres',
            'profissaoRepresentante.max'        => 'A Profissão do Representante deve conter no maximo 50 caracteres',

            'rgRepresentante.min'               => 'O RG do Representante deve conter no minimo 3 caracteres',
            'rgRepresentante.max'               => 'O RG do Representante deve conter no maximo 10 caracteres',

            'cpfRepresentante.required'             => 'O CPF do Representante é Obrigatório',
            'cpfRepresentante.numeric'              => 'O CPF do Representante deve conter apenas numeros',
            'cpfRepresentante.digits_between'       => 'O CPF do Representante deve conter 11 caracteres',

            'ctpsRepresentante.min'             => 'O CTPS do Representante deve conter no minimo 2 caracteres',
            'ctpsRepresentante.max'             => 'O CTPS do Representante deve conter no maximo 15 caracteres',

            'emailRepresentante.min'            => 'O EMAIL do Representante deve conter no minimo 11 caracteres',
            'emailRepresentante.max'            => 'O EMAIL do Representante deve conter no maximo 50 caracteres',

            'orgExpedidorRepresentante.min'     => 'O Orgão Expedidor do Representante deve conter no minimo 2 caracteres',
            'orgExpedidorRepresentante.max'     => 'O Orgão Expedidor do Representante deve conter no maximo 10 caracteres',

            'ufOrgExpedidorRepresentante.min'   => 'A UF Orgão Expedidor do Representante deve conter no minimo 2 caracteres',
            'ufOrgExpedidorRepresentante.max'   => 'A UF Orgão Expedidor do Representante deve conter no maximo 2 caracteres',

            'logradouroRepresentante.required'       => 'O Logradouro do Representante é Obrigatório',
            'logradouroRepresentante.min'       => 'O Logradouro do Representante deve conter no minimo 3 caracteres',
            'logradouroRepresentante.max'       => 'O Logradouro do Representante deve conter no maximo 50 caracteres',

            'numeroRepresentante.required'          => 'O Numero do Representante é Obrigatório',
            'numeroRepresentante.numeric'           => 'O Numero do Representante deve conter apenas numeros',
            'numeroRepresentante.digits_between'    => 'O Numero do Representante deve conter entre 1 e 5 caracteres',

            'complementoRepresentante.min'      => 'O Complemento do Representante deve conter no minimo 4 caracteres',
            'complementoRepresentante.max'      => 'O Complemento do Representante deve conter no maximo 50 caracteres',

            'bairroRepresentante.required'           => 'O Bairro do Representante é Obrigatório',
            'bairroRepresentante.min'                => 'O Bairro do Representante deve conter no minimo 5 caracteres',
            'bairroRepresentante.max'                => 'O Bairro do Representante deve conter no maximo 30 caracteres',

            'cidadeRepresentante.required'           => 'A Cidade do Representante é Obrigatório',
            'cidadeRepresentante.min'                => 'A Cidade do Representante deve conter no minimo 4 caracteres',
            'cidadeRepresentante.max'                => 'A Cidade do Representante deve conter no maximo 30 caracteres',

            'estadoRepresentante.required'           => 'O Estado do Representante é Obrigatório',
            'estadoRepresentante.min'                => 'O Estado do Representante deve conter no minimo 4 caracteres',
            'estadoRepresentante.max'                => 'O Estado do Representante deve conter no maximo 20 caracteres',

        ];
    }

    public function validationData()
    {
        $dados = $this->all();

        //dd($dados);

        $dados['cpfCnpj'] = preg_replace("/[^0-9]/", "", $dados['cpfCnpj']);
        $dados['telefone'] = preg_replace("/[^0-9]/", "", $dados['telefone']);
        $dados['celUm'] = preg_replace("/[^0-9]/", "", $dados['celUm']);
        $dados['celDois'] = preg_replace("/[^0-9]/", "", $dados['celDois']);
        $dados['celTres'] = preg_replace("/[^0-9]/", "", $dados['celTres']);
        $dados['cep'] = preg_replace("/[^0-9]/", "", $dados['cep']);

        $dados['cpfRepresentante'] = preg_replace("/[^0-9]/", "", $dados['cpfRepresentante']);
        $dados['cepRepresentante'] = preg_replace("/[^0-9]/", "", $dados['cepRepresentante']);
        /*
        $posto = Posto::find($dados['posto_id']);
        $dados['nome_guerra'] = $posto->name_abreviado . ' ' .$dados['nome_guerra'];
        */
        return $dados;
    }
}
