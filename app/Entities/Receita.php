<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Receita.
 *
 * @package namespace App\Entities;
 */
class Receita extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'descricao', 'valor'];

}
