<?php
/**
 * Created by PhpStorm.
 * User: SGT FRANCISCO
 * Date: 26/07/2018
 * Time: 10:23
 */

namespace App\Services;

use App\Exceptions\ExceptionsErros;
use App\Repositories\HistoricoProcessoRepository;

class HistoricoProcessosService
{
    protected $repository;
    protected $erros;

    public function __construct(HistoricoProcessoRepository $repository, ExceptionsErros $erros)
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
                'messages' => 'Histórico Cadastrado com Sucesso'
            ];

        } catch (\Exception $e) {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Cadastrar o Histórico.'
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
                'messages' => 'Histórico Atualizado com Sucesso'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Atualizar o Histórico.'
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
                'messages'  => 'Histórico Excluido com Sucesso!'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Excluir o Histórico. Deve existir algum processo atrelado a ele.'
            ];
            //return $this->erros->errosExceptions($e);
        }
    }
    
}
