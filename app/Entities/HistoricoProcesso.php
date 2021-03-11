<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class HistoricoProcesso.
 *
 * @package namespace App\Entities;
 */
class HistoricoProcesso extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id', 'contrato_id', 'titulo', 'tarefa', 'dataTarefa', 'horaTarefa'];

    public function Contrato()
    {
        return $this->belongsTo('App\Entities\Contrato');
    }

}
