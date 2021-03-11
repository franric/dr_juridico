<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContasReceberRepository;
use App\Entities\ContasReceber;
use App\Validators\ContasReceberValidator;

/**
 * Class ContasReceberRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContasReceberRepositoryEloquent extends BaseRepository implements ContasReceberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContasReceber::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
