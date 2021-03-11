<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Historico.
 *
 * @package namespace App\Entities;
 */
class Historico extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id', 'contrato_id', 'historico'];

    public function Pessoa()
    {
        return $this->belongsToMany('App\Entities\Pessoa', 'pessoa_historicos', 'historico_id', 'pessoa_id');
    }

    public function Contrato()
    {
        return $this->belongsTo('App\Entities\Contrato');
    }

}
