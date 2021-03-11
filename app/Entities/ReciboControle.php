<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReciboControle.
 *
 * @package namespace App\Entities;
 */
class ReciboControle extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id', 'contas_receber_id'];

}
