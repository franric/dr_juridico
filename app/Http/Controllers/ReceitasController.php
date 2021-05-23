<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceitaCreateRequest;
use App\Http\Requests\ReceitaUpdateRequest;
use App\Repositories\ReceitaRepository;
use App\Services\ReceitasServices;


class ReceitasController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(ReceitaRepository $repository, ReceitasServices $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    public function index()
    {
        $receita = $this->repository->all();
        return view('admin.receita.index', compact('receita'));
    }


    public function create()
    {
        return view('admin.receita.createEdit');
    }

    public function store(ReceitaCreateRequest $request)
    {
        $receita = $this->service->store($request->all());

        session()->flash('success', [
            'success'   => $receita['success'],
            'messages'  => $receita['messages']
        ]);

        return redirect()->route('receita.index');
    }

    public function edit($id)
    {
        $receita = $this->repository->find($id);

        return view('admin.receita.createEdit', compact('receita'));
    }

    public function update(ReceitaUpdateRequest $request, $id)
    {
        $receita = $this->service->update($request->all(), $id);

        session()->flash('success', [
            'success'   => $receita['success'],
            'messages'  => $receita['messages']
        ]);

        return redirect()->route('receita.index');
    }

    public function show($id)
    {
        $receita = $this->repository->find($id);

        return view('admin.receita.show', compact('receita'));
    }

    public function destroy($id)
    {
        $receita = $this->service->destroy($id);

        session()->flash('success', [
            'success'   => $receita['success'],
            'messages'  => $receita['messages']
        ]);

        return redirect()->route('receita.index');
    }

    public function getReceitaSelect(){

        $receitas = $this->service->getReceitaSelect();
        return Response()->json($receitas);
    }
}
