<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProcuracaoRepository;
use App\Entities\Procuracao;
use App\Validators\ProcuracaoValidator;

/**
 * Class ProcuracaoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProcuracaoRepositoryEloquent extends BaseRepository implements ProcuracaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Procuracao::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
