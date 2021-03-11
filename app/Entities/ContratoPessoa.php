<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ContratoPessoas.
 *
 * @package namespace App\Entities;
 */
class ContratoPessoa extends Model implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;

    protected $fillable = [
        'contrato_id',
        'pessoa_id'
    ];

}
