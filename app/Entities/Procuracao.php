<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Procuracao extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id', 'pessoa_id', 'tipo'];

    public function Pessoa()
    {
        return $this->belongsTo('App\Entities\Pessoa');
    }

}
