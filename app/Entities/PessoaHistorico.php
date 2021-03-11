<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PessoaHistorico.
 *
 * @package namespace App\Entities;
 */
class PessoaHistorico extends Model implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;

    protected $fillable = ['id', 'pessoa_id', 'historico_id'];

}
