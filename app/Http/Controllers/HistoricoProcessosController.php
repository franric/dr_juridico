<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HistoricoProcessoCreateRequest;
use App\Http\Requests\HistoricoProcessoUpdateRequest;
use App\Repositories\HistoricoProcessoRepository;
use App\Services\HistoricoProcessosService;


class HistoricoProcessosController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(HistoricoProcessoRepository $repository, HistoricoProcessosService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        $historicos = $this->repository->all();

        return view('admin.historicoProcesso.index', compact('historicos'));
    }

    public function create()
    {
        return view('admin.historicoProcesso.createEdit');
    }

    public function store(HistoricoProcessoCreateRequest $request)
    {
        $historicoProcesso = $this->service->store($request->all());

        return redirect()->route('historicoProcesso.index');
    }

    public function show($id)
    {
        $historicoProcesso = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $historicoProcesso,
            ]);
        }

        return view('historicoProcessos.show', compact('historicoProcesso'));
    }

    public function edit($id)
    {
        $historicoProcesso = $this->repository->find($id);

        return view('historicoProcessos.edit', compact('historicoProcesso'));
    }

    public function update(HistoricoProcessoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $historicoProcesso = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'HistoricoProcesso updated.',
                'data'    => $historicoProcesso->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'HistoricoProcesso deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'HistoricoProcesso deleted.');
    }
}
