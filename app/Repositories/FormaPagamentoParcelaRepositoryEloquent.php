<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FormaPagamentoParcelaRepository;
use App\Entities\FormaPagamentoParcela;
use App\Validators\FormaPagamentoParcelaValidator;

/**
 * Class FormaPagamentoParcelaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormaPagamentoParcelaRepositoryEloquent extends BaseRepository implements FormaPagamentoParcelaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormaPagamentoParcela::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
