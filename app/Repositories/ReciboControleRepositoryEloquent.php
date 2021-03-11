<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ReciboControleRepository;
use App\Entities\ReciboControle;
use App\Validators\ReciboControleValidator;

/**
 * Class ReciboControleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReciboControleRepositoryEloquent extends BaseRepository implements ReciboControleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReciboControle::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
