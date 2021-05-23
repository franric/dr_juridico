<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FormaPagamentoRepository;
use App\Entities\FormaPagamento;
use App\Validators\FormaPagamentoValidator;

/**
 * Class FormaPagamentoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormaPagamentoRepositoryEloquent extends BaseRepository implements FormaPagamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormaPagamento::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FormaPagamentoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
