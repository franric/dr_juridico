<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContratoReceitaRepository;
use App\Entities\ContratoReceita;
use App\Validators\ContratoReceitaValidator;

/**
 * Class ContratoReceitaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContratoReceitaRepositoryEloquent extends BaseRepository implements ContratoReceitaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContratoReceita::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
