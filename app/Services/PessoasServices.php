<?php
/**
 * Created by PhpStorm.
 * User: SGT FRANCISCO
 * Date: 26/07/2018
 * Time: 10:23
 */

namespace App\Services;

use App\Exceptions\ExceptionsErros;
use App\Repositories\PessoaRepository;

class PessoasServices
{
    protected $repository;
    protected $erros;

    public function __construct(PessoaRepository $repository, ExceptionsErros $erros)
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
                'messages' => 'Cliente Cadastrado com Sucesso'
            ];

        } catch (\Exception $e) {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Cadastrar o Cliente.'
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
                'messages' => 'Cliente Atualizado com Sucesso'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Atualizar o Cliente.'
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
                'messages'  => 'Cliente Excluido com Sucesso!'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Excluir o Cliente. Deve existir algum processo atrelado a ele.'
            ];
            //return $this->erros->errosExceptions($e);
        }
    }

    public function checaClienteCreate(array $request)
    {
        $check = $this->repository->findWhere([
            'id' => $request['id'],
            'cpfCnpj' => $request['cpfCnpj']
        ]);

        if (count($check) > 0) {
            session()->flash('success', [
                'success' => false,
                'messages' => 'Não foi Possivel Cadastrar o Cliente, Já possui cliente cadastrado com esse nome.'
            ]);

            return true;
        }

        return false;
    }

    public function checaClienteUpdate(array $request, $id)
    {
        $check = $this->repository->findWhere([
            'id' => $request['id'],
            'cpfCnpj' => $request['cpfCnpj']
        ])->first();

        if (count($check) > 0) {
            if($check->id != $id)
            {
                session()->flash('success', [
                    'success' => false,
                    'messages' => 'Não foi Possivel Atualizar o Cliente, Já possui cliente cadastrado com esse nome'
                ]);

                return true;
            }
            return false;
        }
        return false;
    }

    public function getClienteSelect()
    {
        $clientes = $this->repository->visible(['id', 'cpfCnpj'])->all();
        return $clientes;
    }
}
