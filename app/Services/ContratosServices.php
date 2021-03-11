<?php

/**
 * Created by PhpStorm.
 * User: SGT FRANCISCO
 * Date: 26/07/2018
 * Time: 10:23
 */

namespace App\Services;

use App\Exceptions\ExceptionsErros;
use App\Repositories\ContratoRepository;
use App\Repositories\ContratoPessoasRepository;
use App\Repositories\ContratoReceitaRepository;

class ContratosServices
{
    protected $repository;
    protected $erros;
    protected $contratoPessoa;
    protected $ContratoReceita;

    public function __construct(ContratoRepository $repository, ContratoPessoasRepository $contratoPessoa, ContratoReceitaRepository $ContratoReceita, ExceptionsErros $erros)
    {
        $this->repository = $repository;
        $this->erros = $erros;
        $this->contratoPessoa = $contratoPessoa;
        $this->ContratoReceita = $ContratoReceita;
    }

    public function store($dados)
    {
        try {
            $contrato = $this->repository->create($dados);

            return [
                'success' => true,
                'messages' => 'Contrato Gerado com Sucesso',
                'contrato' => $contrato
            ];
        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function storeContratoPessoa($dados, $contrato_id)
    {
        try {
            foreach ($dados as $cliente) {

                $this->contratoPessoa->create(
                    [
                        'contrato_id' => $contrato_id,
                        'pessoa_id' =>  $cliente->id
                    ]
                );
            }

            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function storeContratoReceita($dados, $contrato_id)
    {
        try {
            foreach ($dados as $receita) {
                $this->ContratoReceita->create(
                    [
                        'contrato_id' => $contrato_id,
                        'receita_id' =>  $receita->receita_id,
                        'valorReceita' => $receita->Valor
                    ]
                );
            }

            return [
                'success' => true
            ];

        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function update($dados, $id)
    {
        try {

            $contrato = $this->repository->update($dados, $id);

            return [
                'success'   => true,
                'messages'  => 'Contrato Atualizado com Sucesso',
                'contrato' => $contrato
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
                'messages'  => 'Contrato Excluido com Sucesso!'
            ];
        } catch (\Exception $e) {
            return $this->erros->errosExceptions($e);
        }
    }

    public function getContratosSelect()
    {
        $contratos = $this->repository->visible(['id', 'numContrato'])->all();
        return $contratos;
    }
}
