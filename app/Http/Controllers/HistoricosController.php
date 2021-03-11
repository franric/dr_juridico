<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HistoricoCreateRequest;
use App\Http\Requests\HistoricoUpdateRequest;
use App\Repositories\HistoricoRepository;
use App\Services\HistoricosServices;

/**
 * Class HistoricosController.
 *
 * @package namespace App\Http\Controllers;
 */
class HistoricosController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(HistoricoRepository $repository, HistoricosServices $service )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        $historicos = $this->repository->all();

        return view('admin.historico.index', compact('historicos'));
    }

    public function create()
    {
        return view('admin.historico.createEdit');
    }
    public function store(HistoricoCreateRequest $request)
    {
        $clientes = json_decode($request->cliente[0]);

        $historico = $this->service->store($request->all());

        if($historico['success'])
        {
            $historico = $this->service->storePessoaHistorico($clientes, $historico['historico']->id);

            session()->flash('success', [
                'success'   => $historico['success'],
                'messages'  => $historico['messages']
            ]);

        }else {
            session()->flash('success', [
                'success'   => $historico['success'],
                'messages'  => $historico['messages']
            ]);
        }

        return response()->json($historico);
    }

    public function edit($id)
    {
        $historico = $this->repository->find($id);
        return view('admin.historico.createEdit', compact('historico'));
    }

    public function update(HistoricoUpdateRequest $request, $id)
    {
        $clientes = json_decode($request->cliente[0]);

        //Limpar Clientes
        $pessoaHistorico = \App\Entities\PessoaHistorico::where('historico_id', $id)->get(); 

        foreach ($pessoaHistorico as $p) {
            $p->delete();
        }     

        //Cadastrar Clientes
        $historico = $this->service->storePessoaHistorico($clientes, $id);
        
        //Cadastrar Historico
        if($historico['success']) {
            
            $historico = $this->service->update($request->all(), $id);

            session()->flash('success', [
                'success'   => $historico['success'],
                'messages'  => $historico['messages']
            ]);
        }
        
        return response()->json($historico);
    }

    public function updateContratoHistorico(Request $request)
    {          
        $historico = $this->service->update($request->all(), $request->id);

        session()->flash('success', [
            'success'   => $historico['success'],
            'messages'  => $historico['messages']
        ]);      
        
        return response()->json($historico);
    }

    public function show($id)
    {
        $historico = $this->repository->find($id)->pessoa;

        return response()->json($historico);
    }

    public function destroy(Request $id)
    {
        $deleted = $this->service->destroy($id->id);

        session()->flash('success', [
            'success'   => $deleted['success'],
            'messages'  => $deleted['messages']
        ]);

        return redirect()->route('historico.index');
    }
}
