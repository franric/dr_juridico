<?php

/**
 * Created by PhpStorm.
 * User: SGT FRANCISCO
 * Date: 26/07/2018
 * Time: 10:23
 */

namespace App\Services;

use App\Exceptions\ExceptionsErros;
use App\Repositories\ReceitaRepository;

class ReceitasServices
{
    protected $repository;
    protected $erros;

    public function __construct(ReceitaRepository $repository, ExceptionsErros $erros)
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
                'messages' => 'Receita Cadastrado com Sucesso'
            ];
        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function update($dados, $id)
    {
        try {
            $this->repository->update($dados, $id);

            return [
                'success'     => true,
                'messages' => 'Receita Atualizado com Sucesso'
            ];
        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);

            return [
                'success'   => true,
                'messages'  => 'Receita Excluido com Sucesso!'
            ];
        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function getReceitaSelect()
    {
        $receitas = $this->repository->visible(['id', 'descricao', 'valor'])->all();
        return $receitas;
    }
}
