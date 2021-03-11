<?php

use Illuminate\Database\Seeder;
use App\Entities\Pessoa;

class PessoasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pessoa::create([

            'tipoPessoa' => '1',
            'nomeRazaoSocial' => 'pedro paulo',
            'nacionalidade' => 'brasileira',
            'estadoCivil' => 'casado',
            'profissao' => 'Musico',
            'rg' => '123456',
            'cpfCnpj' => '12345678910',
            'ctps' => '12365',
            'email' => 'fulano@email.com',
            'dataNascimento' => '1982-11-15',
            'orgExpedidor' => 'SSP',
            'ufOrgExpedidor' => 'AM',
            'nire' => null,
            'inscEstadual' => null,
            'inscMunicipal' => null,
            'logradouro' => 'Rua sobe e desce',
            'numero' => '2',
            'complemento' => 'qd64',
            'bairro' => 'Planalto',
            'cep' => '69045560',
            'cidade' => 'Manaus',
            'estado' => 'Amazonas',
            'telefone' => null,
            'celUm' => '92994509178',
            'celDois' => null,
            'celTres' => null,
            'nomeRepresentante' => null,
            'nacionalidadeRepresentante' => null,
            'estadoCivilRepresentante' => null,
            'profissaoRepresentante' => null,
            'rgRepresentante' => null,
            'cpfRepresentante' => null,
            'ctpsRepresentante' => null,
            'emailRepresentante' => null,
            'dataNascimentoRepresentante' => null,
            'orgExpedidorRepresentante' => null,
            'ufOrgExpedidorRepresentante' => null,
            'logradouroRepresentante' => null,
            'numeroRepresentante' => null,
            'complementoRepresentante' => null,
            'bairroRepresentante' => null,
            'cepRepresentante' => null,
            'cidadeRepresentante' => null,
            'estadoRepresentante' => null,
            'status' => 1,

            ]);
    }
}

