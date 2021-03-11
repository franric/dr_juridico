<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\HistoricoRepository;
use App\Entities\Historico;
use App\Validators\HistoricoValidator;

/**
 * Class HistoricoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HistoricoRepositoryEloquent extends BaseRepository implements HistoricoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Historico::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
