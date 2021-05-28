<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FormaPagamento.
 *
 * @package namespace App\Entities;
 */
class FormaPagamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id', 'descricao'];

    public function Parcela()
    {
        return $this->belongsToMany('App\Entities\ContasReceber', 'forma_pagamento_parcelas', 'parcela_id', 'forma_pagamento_id');
    }
}
