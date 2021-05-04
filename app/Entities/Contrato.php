<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Contrato.
 *
 * @package namespace App\Entities;
 */
class Contrato extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [

        'id',
        'numContrato',
        'objetoContrato',
        'valorExteContrato',
        'valorExteEntContrato',
        'comarcaCidadeContrato',
        'comarcaEstadoContrato',
        'valorExtePorcContrato',
        'dataVencContrato',
        'valorContrato',
        'valorEntradaContrato',
        'numParcelaContrato',
        'statusContrato',
        'dataBaixaContrato'
    ];

    public function Pessoa()
    {
        return $this->belongsToMany('App\Entities\Pessoa', 'contrato_pessoas', 'contrato_id', 'pessoa_id');
    }

    public function Receita()
    {
        return $this->belongsToMany('App\Entities\Receita', 'contrato_receitas', 'contrato_id', 'receita_id');
    }

    public function ContasReceber()
    {
        return $this->hasMany('App\Entities\ContasReceber');
    }

    public function HistoricoProcesso()
    {
        return $this->hasMany('App\Entities\HistoricoProcesso');
    }

    public function ReciboQuitacaoControlhe()
    {
        return $this->hasOne(ReciboQuitacaoControlhe::class);
    }

}
