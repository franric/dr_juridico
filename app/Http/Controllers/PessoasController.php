<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PessoaRepository;
use App\Http\Requests\PessoaCreateRequest;
use App\Http\Requests\PessoaUpdateRequest;
use App\Services\PessoasServices;
use App\Funcoes\ConvertNumeroTexto;


class PessoasController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(PessoaRepository $repository, PessoasServices $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    public function index()
    {
        $clientes = $this->repository->all();

        foreach ($clientes as $pessoa) {
            $pessoa->cpfCnpj = ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj);
            $pessoa->celUm = ConvertNumeroTexto::formatPhone($pessoa->celUm);
        }

        return view('admin.cliente.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.cliente.createEdit');
    }

    public function store(PessoaCreateRequest $request)
    {

        $request['cpfCnpj'] = preg_replace("/[^0-9]/", "", $request->cpfCnpj);
        $request['telefone'] = preg_replace("/[^0-9]/", "", $request->telefone);
        $request['celUm'] = preg_replace("/[^0-9]/", "", $request->celUm);
        $request['celDois'] = preg_replace("/[^0-9]/", "", $request->celDois);
        $request['celTres'] = preg_replace("/[^0-9]/", "", $request->celTres);
        $request['cep'] = preg_replace("/[^0-9]/", "", $request->cep);

        $request['cpfRepresentante'] = preg_replace("/[^0-9]/", "", $request->cpfRepresentante);
        $request['cepRepresentante'] = preg_replace("/[^0-9]/", "", $request->cepRepresentante);

        //dd($request->all());

        $pessoa = $this->service->store($request->all());

        session()->flash('success', [
            'success'   => $pessoa['success'],
            'messages'  => $pessoa['messages']
        ]);

        return redirect()->route('pessoa.index');
    }

    public function show($id)
    {
        $cliente = $this->repository->find($id);
        $cliente->cpfCnpj = ConvertNumeroTexto::formatCnpjCpf($cliente->cpfCnpj);
        return response()->json($cliente);
    }

    public function edit($id)
    {
        $cliente = $this->repository->find($id);

        return view('admin.cliente.createEdit', compact('cliente'));
    }

    public function update(PessoaUpdateRequest $request, $id)
    {
        $request['cpfCnpj'] = preg_replace("/[^0-9]/", "", $request->cpfCnpj);
        $request['telefone'] = preg_replace("/[^0-9]/", "", $request->telefone);
        $request['celUm'] = preg_replace("/[^0-9]/", "", $request->celUm);
        $request['celDois'] = preg_replace("/[^0-9]/", "", $request->celDois);
        $request['celTres'] = preg_replace("/[^0-9]/", "", $request->celTres);
        $request['cep'] = preg_replace("/[^0-9]/", "", $request->cep);

        $request['cpfRepresentante'] = preg_replace("/[^0-9]/", "", $request->cpfRepresentante);
        $request['cepRepresentante'] = preg_replace("/[^0-9]/", "", $request->cepRepresentante);

        //dd($request->all(), $id);

        $cliente = $this->service->update($request->all(), $id);

        session()->flash('success', [
            'success' => $cliente['success'],
            'messages' => $cliente['messages']
        ]);

        return redirect()->route('pessoa.index');
    }

    public function excluirPessoa($id)
    {
        $cliente = $this->service->destroy($id);

        return response()->json($cliente);
    }

    public function getClienteSelect(){

        $clientes = $this->service->getClienteSelect();
        foreach ($clientes as $cliente) {
            $cliente->cpfCnpj = \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($cliente->cpfCnpj);
        }
        return Response()->json($clientes);
    }
}
