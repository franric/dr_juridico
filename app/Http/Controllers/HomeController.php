<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contrato =         \App\Entities\Contrato::where('statusContrato', 1)->count();
        $cliente =          \App\Entities\Pessoa::where('status', 1)->count();
        $recebidoMensal =   \App\Entities\ContasReceber::whereMonth('dataVencimento', date('m'))->where('statusRecebimento', 0)->sum('valorRecebido');
        $aReceberMensal =   \App\Entities\ContasReceber::whereMonth('dataVencimento', date('m'))->where('statusRecebimento', 1)->sum('valorParcela');
        $recebidoAnual =    \App\Entities\ContasReceber::whereYear('dataVencimento', date('Y'))->where('statusRecebimento', 0)->sum('valorRecebido');
        $aReceberAnual =    \App\Entities\ContasReceber::whereYear('dataVencimento', date('Y'))->where('statusRecebimento', 1)->sum('valorParcela');
        $emAtraso =    \App\Entities\ContasReceber::where('dataVencimento', '<', date('Y-m-d'))->where('statusRecebimento', 1)->sum('valorParcela');

        $dashboard = [
            'contrato' => $contrato,
            'cliente' => $cliente,
            'recebidoMensal' => $recebidoMensal,
            'aReceberMensal' => $aReceberMensal,
            'recebidoAnual' => $recebidoAnual,
            'aReceberAnual' => $aReceberAnual,
            'emAtraso' => $emAtraso
        ];

        return view('admin.home.index', compact('dashboard'));
    }
}
