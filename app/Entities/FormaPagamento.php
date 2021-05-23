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

}
