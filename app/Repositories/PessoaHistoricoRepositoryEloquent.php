<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PessoaHistoricoRepository;
use App\Entities\PessoaHistorico;
use App\Validators\PessoaHistoricoValidator;

/**
 * Class PessoaHistoricoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PessoaHistoricoRepositoryEloquent extends BaseRepository implements PessoaHistoricoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PessoaHistorico::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
