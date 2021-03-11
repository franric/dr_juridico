<?php
/**
 * Created by PhpStorm.
 * User: SGT FRANCISCO
 * Date: 26/07/2018
 * Time: 10:23
 */

namespace App\Services;

use App\Repositories\HistoricoRepository;
use App\Repositories\PessoaHistoricoRepository;

class HistoricosServices
{
    protected $repository;
    protected $pessoaHistorico;

    public function __construct(HistoricoRepository $repository, PessoaHistoricoRepository $pessoaHistorico)
    {
        $this->repository = $repository;
        $this->pessoaHistorico = $pessoaHistorico;
    }

    public function store($dados)
    {
        try {
            $historico = $this->repository->create($dados);

            return [
                'success' => true,
                'messages' => 'Historico Cadastrado com Sucesso',
                'historico' => $historico
            ];

        } catch (\Exception $e) {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Cadastrar o Historico.'
            ];
        }
    }

    public function update($dados, $id)
    {
        try
        {
            $this->repository->update($dados, $id);

            return [
              'success'     => true,
                'messages' => 'Historico Atualizado com Sucesso'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Atualizar o Historico.'
            ];
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->repository->delete($id);

            return [
                'success'   => true,
                'messages'  => 'Historico Excluido com Sucesso!'
            ];

        }catch (\Exception $e)
        {
            return [
                'success'   => false,
                'messages'  => 'Não foi possivel Excluir o Historico. Deve existir algum processo atrelado a ele.'
            ];
        }
    }

    public function storePessoaHistorico($dados, $historico_id)
    {
        try {
            foreach ($dados as $pessoa) {
                $this->pessoaHistorico->create(
                    [
                        'historico_id' => $historico_id,
                        'pessoa_id' =>  $pessoa->codigoCliente
                    ]
                );
            }

            return [
                'success' => true,
                'messages' => 'Historico Cadastrado com Sucesso'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'messages'  => $e
            ];
        }
    }

}
