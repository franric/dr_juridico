<?php
/**
 * Created by PhpStorm.
 * User: SGT FRANCISCO
 * Date: 26/07/2018
 * Time: 10:23
 */

namespace App\Services;

use App\Exceptions\ExceptionsErros;
use App\Repositories\ProcuracaoRepository;

class ProcuracaosServices
{
    protected $repository;
    protected $erros;

    public function __construct(ProcuracaoRepository $repository, ExceptionsErros $erros)
    {
        $this->repository = $repository;
        $this->erros = $erros;
    }

    public function store($dados)
    {
        try {
            $this->repository->create($dados);

            return [
                'success' => true,
                'messages' => 'Procuração Cadastrada com Sucesso'
            ];

        } catch (\Exception $e) {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Cadastrar a Procuração.'
            ];
            //return $this->erros->errosExceptions($e);
        }

    }

    public function update($dados, $id)
    {
        try
        {
            $this->repository->update($dados, $id);

            return [
              'success'     => true,
                'messages' => 'Procuração Atualizado com Sucesso'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Atualizar a Procuração.'
            ];
            //return $this->erros->errosExceptions($e);
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->repository->delete($id);

            return [
                'success'   => true,
                'messages'  => 'Procuração Excluida com Sucesso!'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Excluir a Procuração. Deve existir algum processo atrelado a ele.'
            ];
            //return $this->erros->errosExceptions($e);
        }
    }



}
