<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FormaPagamentoParcela.
 *
 * @package namespace App\Entities;
 */
class FormaPagamentoParcela extends Model implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;

    protected $fillable = [
        'parcela_id',
        'forma_pagamento_id'
    ];

}
