<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ContasReceber.
 *
 * @package namespace App\Entities;
 */
class ContasReceber extends Model implements Transformable
{
    use TransformableTrait;


    protected $fillable = [
        'id',
        'contrato_id',
        'tipoPagamento',
        'valorParcela',
        'valorRecebido',
        'dataVencimento',
        'dataRecebimento',
        'numeroParcela',
        'statusRecebimento'
    ];

    public function Contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function Recibo()
    {
        return $this->hasOne(ReciboControle::class);
    }

}
