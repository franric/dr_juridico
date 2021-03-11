<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pessoa.
 *
 * @package namespace App\Entities;
 */
class Pessoa extends Model implements Transformable
{
    use TransformableTrait;
    //use SoftDeletes;

    //protected $dates = ['deleted_at'];

    protected $fillable = [

        'id',
        'tipoPessoa',
        'nomeRazaoSocial',
        'nacionalidade',
        'estadoCivil',
        'profissao',
        'rg',
        'cpfCnpj',
        'ctps',
        'email',
        'dataNascimento',
        'orgExpedidor',
        'ufOrgExpedidor',
        'nire',
        'inscEstatual',
        'inscMunicipal',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'telefone',
        'celUm',
        'celDois',
        'celTres',
        'nomeRepresentante',
        'nacionalidadeRepresentante',
        'estadoCivilRepresentante',
        'profissaoRepresentante',
        'rgRepresentante',
        'cpfRepresentante',
        'ctpsRepresentante',
        'emailRepresentante',
        'dataNascimentoRepresentante',
        'orgExpedidorRepresentante',
        'ufOrgExpedidorRepresentante',
        'logradouroRepresentante',
        'numeroRepresentante',
        'complementoRepresentante',
        'bairroRepresentante',
        'cepRepresentante',
        'cidadeRepresentante',
        'estadoRepresentante',
        'status',
    ];

    public function Contrato()
    {
        return $this->belongsToMany('App\Entities\Contrato', 'contrato_pessoas', 'pessoa_id', 'contrato_id');
    }

}
