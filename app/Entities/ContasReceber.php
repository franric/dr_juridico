<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use DB;
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

    public function FormaPagamento()
    {
        return $this->belongsToMany('App\Entities\FormaPagamento', 'forma_pagamento_parcelas', 'parcela_id', 'forma_pagamento_id');
    }

    public static function Teste() {
        $users = ContasReceber::select(DB::raw('dataVencimento, sum(valorParcela)'))
                     ->where('statusRecebimento', 1)
                     ->whereYear('dataVencimento', 2021)
                     ->groupBy(DB::raw('(month(dataVencimento))'))
                     ->get();

        return $users;
    }
}
