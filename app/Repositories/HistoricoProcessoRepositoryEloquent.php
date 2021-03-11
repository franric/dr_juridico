<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\HistoricoProcessoRepository;
use App\Entities\HistoricoProcesso;
use App\Validators\HistoricoProcessoValidator;

/**
 * Class HistoricoProcessoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HistoricoProcessoRepositoryEloquent extends BaseRepository implements HistoricoProcessoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HistoricoProcesso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
