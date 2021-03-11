<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contrato_pessoasRepository;
use App\Entities\ContratoPessoa;
use App\Validators\ContratoPessoasValidator;

/**
 * Class ContratoPessoasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContratoPessoasRepositoryEloquent extends BaseRepository implements ContratoPessoasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContratoPessoa::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
