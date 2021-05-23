<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FormaPagamentoCreateRequest;
use App\Http\Requests\FormaPagamentoUpdateRequest;
use App\Repositories\FormaPagamentoRepository;
use App\Services\FormaPagamentosServices;

class FormaPagamentosController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(FormaPagamentoRepository $repository, FormaPagamentosServices $service)
    {
        $this->repository = $repository;
        $this->service  = $service;
    }

    public function index()
    {
        $formaPagamentos = $this->repository->all();

        return view('admin.formaPagamento.index', compact('formaPagamentos'));
    }

    public function create()
    {
        return view('admin.formaPagamento.createEdit');
    }

    public function store(FormaPagamentoCreateRequest $request)
    {

        $formaPagamento = $this->service->store($request->all());

        session()->flash('success', [
            'success' => $formaPagamento['success'],
            'messages'  => $formaPagamento['messages']
        ]);

        return redirect()->route('formaPagamento.index');
    }

    public function edit($id)
    {
        $formaPagamento = $this->repository->find($id);

        return view('admin.formaPagamento.createEdit', compact('formaPagamento'));
    }

    public function update(FormaPagamentoUpdateRequest $request, $id)
    {
        $formaPagamento = $this->service->update($request->all(), $id);

        session()->flash('success', [
            'success'   => $formaPagamento['success'],
            'messages'  => $formaPagamento['messages'],
        ]);

        return redirect()->route('formaPagamento.index');
    }

    public function show($id)
    {
        $formaPagamento = $this->repository->find($id);

        return view('admin.formaPagamento.show', compact('formaPagamento'));
    }

    public function destroy($id)
    {
        $formaPagamento = $this->service->destroy($id);

        session()->flash('success', [
            'success'   => $formaPagamento['success'],
            'messages'  => $formaPagamento['messages']
        ]);

        return redirect()->route('formaPagamento.index');
    }
}
