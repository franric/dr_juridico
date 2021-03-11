<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@index')->name('login');
Route::post('/logar', 'LoginController@logar')->name('logar');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/home', 'HomeController@index')->name('home');

    // ############################# Pessoa #############################
    Route::resource('pessoa', 'PessoasController');
    Route::get('ExcluirCliente/{id}', 'PessoasController@excluirPessoa');
    Route::get('getClienteSelect', 'PessoasController@getClienteSelect')->name('getClienteSelect');

    // ############################# Receita #############################
    Route::resource('receita', 'ReceitasController');
    Route::get('getReceitaSelect', 'ReceitasController@getReceitaSelect')->name('getReceitaSelect');

    // ############################# Contrato #############################
    Route::resource('contrato', 'ContratosController');
    //Route::post('/contrato/store', 'ContratosController@store');
    Route::get('/ContratoPessoa/{cpfcnpj}', 'ContratosController@GetPessoaContrato');
    Route::post('storeReceita', 'ContratosController@storeReceita')->name('storeReceita');
    Route::get('/contratoView/{id}', 'ContratosController@viewContrato');
    Route::get('/contrato/PdfGenerete/{id}', 'ContratosController@PdfGenerete');
    Route::get('/contrato/WordGenerate/{id}', 'ContratosController@WordGenerate');
    Route::get('/getContratosSelect', 'ContratosController@getContratosSelect');

    // ############################# Contas Receber #############################
    Route::resource('contasReceber', 'ContasRecebersController');
    Route::get('/contasReceberContrato/{id}/{data}', 'ContasRecebersController@contasReceberContrato');
    Route::get('/parcelas/{id}', 'ContasRecebersController@PagarParcela')->name('parcela');
    Route::post('finalizarPagamento', 'ContasRecebersController@finalizarPagamento')->name('contasReceber.finalizarPagamento');
    Route::get('/imprimirRecibo/{id}', 'ContasRecebersController@imprimirRecibo');

    // ############################# Histórico Clientes #############################
    Route::resource('historico', 'HistoricosController');
    Route::post('/historico/Excluir', 'HistoricosController@destroy')->name('historico.excluir');
    Route::post('/contratoHistorico', 'HistoricosController@updateContratoHistorico');

    // ############################# Procuração #############################
    Route::resource('procuracao', 'ProcuracaosController');
    Route::get('/gerarProcuracao/{id}', 'ProcuracaosController@WordGenerate');
    Route::get('/procuracao/excluir/{id}', 'ProcuracaosController@destroy');

    // ############################# Procuração #############################
    Route::resource('historicoProcesso', 'HistoricoProcessosController');
});
