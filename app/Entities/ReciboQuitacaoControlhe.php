<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Traits\TransformableTrait;

class ReciboQuitacaoControlhe extends Model
{
    use TransformableTrait;

    protected $fillable = ['id', 'contrato_id'];
}
