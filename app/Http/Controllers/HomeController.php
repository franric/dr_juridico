<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ContasReceberRepository;

class HomeController extends Controller
{
    protected $contasReceber;

    public function __construct(ContasReceberRepository $contasReceber)
    {
        $this->middleware('auth');

        $this->contasReceber = $contasReceber;
    }

    public function index()
    {
        $contrato                   = \App\Entities\Contrato::where('statusContrato', 1)->count();
        $recebidoMensal             = \App\Entities\ContasReceber::whereMonth('dataRecebimento', date('m'))->whereYear('dataRecebimento', date('Y'))->where('statusRecebimento', 0)->sum('valorRecebido');
        $aReceberMensal             = \App\Entities\ContasReceber::whereMonth('dataVencimento', date('m'))->whereYear('dataVencimento', date('Y'))->where('statusRecebimento', 1)->sum('valorParcela');
        $recebidoAnual              = \App\Entities\ContasReceber::whereYear('dataRecebimento', date('Y'))->where('statusRecebimento', 0)->sum('valorRecebido');
        $aReceberAnual              = \App\Entities\ContasReceber::whereYear('dataVencimento', date('Y'))->where('statusRecebimento', 1)->sum('valorParcela');
        $emAtraso                   = \App\Entities\ContasReceber::where('dataVencimento', '<', date('Y-m-d'))->where('statusRecebimento', 1)->sum('valorParcela');
        $clientesAtrasoValorTotal   = \App\Entities\ContasReceber::where('dataVencimento', '<', now())->where('statusRecebimento', 1)->sum('valorParcela');
        $clientesAtraso = $this->contasReceber->findWhere(
            [
                'statusRecebimento' => '1',
                ['dataVencimento', '<', now()]
            ]
        )->groupBy('contrato_id');

        /*
        $posts              = \App\Entities\ContasReceber::Teste();
                
        dd($posts);
     */
        $dashboard = [
            'contrato'                  => $contrato,
            'recebidoMensal'            => $recebidoMensal,
            'aReceberMensal'            => $aReceberMensal,
            'recebidoAnual'             => $recebidoAnual,
            'aReceberAnual'             => $aReceberAnual,
            'emAtraso'                  => $emAtraso,
            'clientesAtraso'            => $clientesAtraso,
            'clientesAtrasoValorTotal'  => $clientesAtrasoValorTotal,
            //'posts'                     => $posts
        ];

        return view('admin.home.index', compact('dashboard'));
    }
}
