<?php

namespace App\Http\Controllers;

use App\Funcoes\ConvertNumeroTexto;

use Illuminate\Http\Request;
use App\Http\Requests\ContratoCreateRequest;
use App\Http\Requests\ContratoUpdateRequest;
use App\Repositories\ContratoRepository;
use App\Repositories\PessoaRepository;
use App\Repositories\ContratoPessoasRepository;
use App\Services\ContratosServices;
use Illuminate\View\View;
use PDF;

class ContratosController extends Controller
{
    protected $repository;
    protected $service;
    protected $pessoa;
    protected $contratoPessoa;

    public function __construct(ContratoRepository $repository, ContratosServices $service, PessoaRepository $pessoa, ContratoPessoasRepository $contratoPessoa)
    {
        $this->repository = $repository;
        $this->service  = $service;
        $this->pessoa = $pessoa;
        $this->contratoPessoa = $contratoPessoa;
    }

    public function index()
    {
        $contrato = $this->repository->all();

        return view('admin.contrato.index', compact('contrato'));
    }

    public function create()
    {
        return view('admin.contrato.createEdit');
    }

    public function GetPessoaContrato($cpfcnpj)
    {
        $pessoaContrato = $this->pessoa->findByField('cpfcnpj', $cpfcnpj);
        return Response()->json($pessoaContrato);
    }

    public function store(ContratoCreateRequest $request)
    {
        $clientes = json_decode($request->cliente[0]);
        $receitas = json_decode($request->receita[0]);
        $dataVencimentoEntrada = $request->dataVencEntrada;

        $request['numContrato'] = date('Y') . str_pad(($this->repository->all()->count() + 1), 4, 0, STR_PAD_LEFT);
        $request['valorExteContrato'] = ConvertNumeroTexto::valorPorExtenso($request->valorContrato, true, false);
        $request['valorExteEntContrato'] = ConvertNumeroTexto::valorPorExtenso($request->valorEntradaContrato, true, false);

        if ($request['numParcelaContrato'] > 0) {
            $valorParcela = (($request['valorContrato'] - $request['valorEntradaContrato']) / $request['numParcelaContrato']);
        }  else {
            $valorParcela = ($request['valorContrato'] - $request['valorEntradaContrato']);
        }

        $valorPagarContrato = (($valorParcela * $request['numParcelaContrato']) + $request['valorEntradaContrato']);

        if($request['valorContrato'] > $valorPagarContrato){
            $contrato['success'] = false;
            $contrato['messages'] = 'O valor de entrada e parcelamento e menor que o valor do contrato';

            return response()->json($contrato);
        }

        $contrato = $this->service->store($request->all());

        if ($contrato['success']) {

            $pessoa = $this->service->storeContratoPessoa($clientes, $contrato['contrato']->id);

            if ($pessoa['success']) {

                $receita = $this->service->storeContratoReceita($receitas, $contrato['contrato']->id);

                if ($receita['success']) {

                    session()->flash('success', [
                        'success'   => $contrato['success'],
                        'messages'  => $contrato['messages']
                    ]);
                } else {
                    $contrato['success'] = false;
                    $contrato['messages'] = 'A Receita n??o foi inserida no contrato';
                }
            } else {
                $contrato['success'] = false;
                $contrato['messages'] = 'O Cliente n??o foi inserido no contrato';
            }
        }

        $contrato['dataVencEntrada'] = $dataVencimentoEntrada;

        return response()->json($contrato);
    }

    public function edit($id)
    {
        $receita = $this->repository->find($id);

        return view('admin.contrato.createEdit', compact('contrato'));
    }

    public function update(ContratoUpdateRequest $request, $id)
    {
        $contrato = $this->service->update($request->all(), $id);

        session()->flash('success', [
            'success'   => $contrato['success'],
            'messages'  => $contrato['messages']
        ]);

        return redirect()->route('contrato.index');
    }

    public function show($id)
    {
        $contrato = $this->repository->find($id);

        return view('admin.contrato.show', compact('contrato'));
    }

    public function destroy($id)
    {
        $contrato = $this->service->destroy($id);

        session()->flash('success', [
            'success'   => $contrato['success'],
            'messages'  => $contrato['messages']
        ]);

        return redirect()->route('contrato.index');
    }

    public function getContratosSelect(){

        $contratos = $this->service->getContratosSelect();
        return Response()->json($contratos);
    }

    public function viewContrato($id)
    {
        $contratos = $this->repository->find($id);
        $contratos['numParcelaExtenso'] = ConvertNumeroTexto::valorPorExtenso($contratos->numParcelaContrato, false, false);

        if($contratos->numParcelaContrato > 0)
            $contratos['valorParcelaContrato'] = ($contratos->valorContrato - $contratos->valorEntradaContrato) /  $contratos->numParcelaContrato;

        $contratos['valorParcelaContratoExtenso'] = ConvertNumeroTexto::valorPorExtenso(number_format($contratos->valorParcelaContrato, 2, ',', '.'), true, false);

        return view('admin.contrato.viewContrato', compact('contratos'));
    }

    public function PdfGenerete($id)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $contratos = $this->repository->find($id);
        $contratos['numParcelaExtenso'] = ConvertNumeroTexto::valorPorExtenso($contratos->numParcelaContrato, false, false);
        if($contratos->numParcelaContrato > 0)
            $contratos['valorParcelaContrato'] = ($contratos->valorContrato - $contratos->valorEntradaContrato) /  $contratos->numParcelaContrato;

        $contratos['valorParcelaContratoExtenso'] = ConvertNumeroTexto::valorPorExtenso(number_format($contratos->valorParcelaContrato, 2, ',', '.'), true, false);

        $file = "DRHN" . $contratos->numContrato . ".pdf";
        //$pdf = PDF::loadView('admin.contrato.pdf', compact('contratos'))
        $pdf = PDF::loadHTML($this->convertToHtml($contratos))
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->setWarnings(false)
            ->download($file);
            //->stream($file);
        return $pdf;
    }

    public function WordGenerate($id)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $contratos = $this->repository->find($id);

        $contratos['numParcelaExtenso'] = ConvertNumeroTexto::valorPorExtenso($contratos->numParcelaContrato, false, false);
        if($contratos->numParcelaContrato > 0)
            $contratos['valorParcelaContrato'] = ($contratos->valorContrato - $contratos->valorEntradaContrato) /  $contratos->numParcelaContrato;

        $contratos['valorParcelaContratoExtenso'] = ConvertNumeroTexto::valorPorExtenso(number_format($contratos->valorParcelaContrato, 2, ',', '.'), true, false);


        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('pTituloCenter', array('alignment' => 'center'));
        $phpWord->addParagraphStyle('pPadrao', array('alignment' => 'both'));
        $phpWord->addParagraphStyle('pPadraoTab', array('widowControl' => false, 'alignment' => 'both', 'indentation' => array('left' => 500)));
        $phpWord->addParagraphStyle('pTituloLeft', array('alignment' => 'left'));
        $phpWord->addFontStyle('fTituloCenter', array('name' => 'Arial', 'size' => '11', 'bold' => true));
        $phpWord->addFontStyle('fPadrao', array('name' => 'Arial', 'size' => '10'));
        $phpWord->addFontStyle('fPadraoBold', array('name' => 'Arial', 'size' => '10', 'bold' => true));
        $phpWord->addFontStyle('fPadraoBoldItalico', array('name' => 'Arial', 'size' => '10', 'bold' => true, 'italic' => true));
        $phpWord->addFontStyle('fPadraoBoldSubli', array('name' => 'Arial', 'size' => '10', 'bold' => true, 'underline' => 'single'));

        $section = $phpWord->addSection();

        // Add first page header
        $header = $section->addHeader();
        $table = $header->addTable();
        $table->addRow();
        $table->addCell(3500)->addImage(
            'imagens/logo_dr.png',
            array('width' => 60, 'height' => 50, 'align' => 'left')
        );
        $cell = $table->addCell(5500);
        $textrun = $cell->addTextRun(array('alignment' => 'right', 'valign' => 'bottom'));
        $textrun = $cell->addTextRun(array('alignment' => 'right', 'valign' => 'bottom'));
        $textrun->addText('Dra. Danielle Rufino Alves Ricardo ??? ', array('italic' => true ));
        $textrun->addText('OAB/AM 3643', array('italic' => true, 'size' => 8 ));
        $textrun = $cell->addTextRun(array('alignment' => 'right', 'valign' => 'bottom'));
        $textrun->addText('OAB/RN 1324-A', array('italic' => true, 'size' => 8));
        $lineStyle = array('weight' => 2, 'width' => 450, 'height' => 2, 'color' => 'blue');
        $header->addLine($lineStyle);
        //$header->addWatermark('imagens/logo_dr.png', array('width' => 450, 'height' => 400));

        // Add footer
        $footer = $section->addFooter();
        $footer->addLine($lineStyle);
        $footer->addText('Rua Val??ncia, n?? 2, Q/64, Conj. Campos Eliseos ??? Planalto, CEP: 69045-560. MAO/AM.', array('italic' => true), array('align' => 'right'));
        $footer->addText('Email: danielle.adv@hotmail.com', array('italic' => true), array('align' => 'right'));

        $section->addText(
            'CONTRATO HONOR??RIOS ADVOCAT??CIOS N?? DRHN_' . $contratos->numContrato,
            'fTituloCenter',
            'pTituloCenter'
        );
        $section->addTextBreak(1);
        $section->addText(
            'IDENTIFICA????O DAS PARTES CONTRATANTES',
            'fTituloCenter',
            'pTituloCenter'
        );

        foreach ($contratos->Pessoa as $pessoa) {

            if ($pessoa->tipoPessoa == 1) {
                $textRun = $section->addTextRun('pPadrao');
                $textRun->addText('CONTRATANTE: ' . $pessoa->nomeRazaoSocial, 'fPadraoBold');
                $textRun->addText(
                    ', ' . $pessoa->nacionalidade . ', ' . $pessoa->profissao . ', ' . $pessoa->estadoCivil . ', portador do RG '
                    . 'N?? ' . $pessoa->rg . ' ' . $pessoa->orgExpedidor . '/' . $pessoa->ufOrgExpedidor . ', CPF N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) . ' com endere??o nesta Cidade na ' . $pessoa->logradouro . ', '
                    . 'N?? ' . $pessoa->numero . ', ' . (isset($pessoa->complemento) ? $pessoa->complemento . " - " : "") . ' ' . $pessoa->bairro . ', CEP: ' . $pessoa->cep . ' e-mail: ' . $pessoa->email,
                    'fPadrao');
            } else {
                $textRun = $section->addTextRun('pPadrao');
                $textRun->addText('CONTRATANTE: ' . $pessoa->nomeRazaoSocial, 'fPadraoBold');
                $textRun->addText(', devidamente inscrita sob o '
                    . 'CNPJ ' .ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) . ' (Doc Digitalizado), registrada na Junta Comercial do Estado do Amazonas '
                    . 'NIRE n?? ' . $pessoa->nire . ', estabelecida na ' . $pessoa->logradouro . ', N?? ' . $pessoa->numero . ', ' . (isset($pessoa->complemento) ? $pessoa->complemento . " - " : "") . ' ' . $pessoa->bairro . ', CEP: ' . $pessoa->cep . ' neste ato '
                    . 'representado pelo Sr. ');
                $textRun->addText($pessoa->nomeRepresentante, 'fPadraoBold');
                $textRun->addText(', ' . $pessoa->nacionalidadeRepresentante . ', ' . $pessoa->profissaoRepresentante . ', portador do RG '
                    . 'N?? ' . $pessoa->rgRepresentante . ' ' . $pessoa->orgExpedidorRepresentante . '/' . $pessoa->ufOrgExpedidorRepresentante . ', CPF N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfRepresentante) . 'com endere??o nesta Cidade na '
                    . $pessoa->logradouroRepresentante . ', N?? ' . $pessoa->numeroRepresentante . ', ' . (isset($pessoa->complementoRepresentante) ? $pessoa->complementoRepresentante . " - " : "") . ' ' . $pessoa->bairroRepresentante . ', CEP: ' . $pessoa->cepRepresentante . 'e-mail: ' . $pessoa->emailRepresentante);
            }
        }

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('CONTRATADA: Dra. DANIELLE RUFINO ALVES RICARDO', 'fPadraoBold');
        $textRun->addText(', brasileira, casada, Advogada, inscrita regularmente na Ordem dos Advogados do Brasil, Se????o/AM sob o n.?? 3.643, Se????o/RN sob o n??mero n.?? 1324-A com escrit??rio profissional na Cidade de Manaus/AM ?? Rua Val??ncia, n?? 02, Q/64, Conj. Campos Eliseos - Planalto, CEP: 69045-560. E-mail: atendimento@drconsultoriajur??dica.com; cel(92)98475-9875;');

        $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('As partes acima identificadas t??m, entre si, justo e acertado o presente Contrato de Honor??rios Advocat??cios, que se reger?? pelas cl??usulas seguintes e pelas condi????es descritas no presente.', 'fPadraoBoldItalico');

        $section -> addTextBreak(1);

        //DO OBJETO DO CONTRATO
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DO OBJETO DO CONTRATO', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 1??. ', 'fPadraoBold');
        $textRun->addText('O presente instrumento tem como OBJETO a presta????o de servi??os advocat??cios referentes a ');
        $textRun->addText($contratos->objetoContrato . '.', 'fPadraoBold');

        $section -> addTextBreak(1);

        //DAS ATIVIDADES
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DAS ATIVIDADES', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 2??. ', 'fPadraoBold');
        $textRun->addText('As atividades inclusas na presta????o de servi??o objeto deste instrumento s??o todas aquelas '
                            . 'inerentes ?? profiss??o, quais sejam:');
        $textRun = $section->addTextRun('pPadraoTab');
        $textRun->addText('a) ', 'fPadraoBold');
        $textRun->addText('Praticar quaisquer atos e medidas necess??rias e inerentes ?? causa, em todas as reparti????es '
                            . 'p??blicas da Uni??o, dos Estados ou dos Munic??pios, bem como ??rg??os a estes ligados direta ou '
                            . 'indiretamente, seja por delega????o, concess??o ou outros meios, bem como de estabelecimentos particulares.', null, array('widowControl' => false, 'indentation' => array('left' => 240, 'right' => 120)));
        $textRun = $section->addTextRun('pPadraoTab');
        $textRun->addText('b) ', 'fPadraoBold');
        $textRun->addText('Praticar todos os atos inerentes ao exerc??cio da advocacia e aqueles constantes no Estatuto da '
                            . 'Ordem dos Advogados do Brasil, bem como os especificados no Instrumento Procurat??rio');

        $section -> addTextBreak(1);

        //DOS ATOS PROCESSUAIS
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DOS ATOS PROCESSUAIS', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 3??. ', 'fPadraoBold');
        $textRun->addText('Havendo necessidade de contrata????o de outros profissionais, no decurso do processo, a ');
        $textRun->addText('CONTRATADA ', 'fPadraoBold');
        $textRun->addText('elaborar?? substabelecimento, indicando escrit??rio de seu conhecimento, restando facultado ao ');
        $textRun->addText('CONTRATANTE ', 'fPadraoBold');
        $textRun->addText('aceit??-lo ou n??o. Aceitando, ficar?? sob a responsabilidade, ??nica e exclusivamente do ');
        $textRun->addText('CONTRATANTE ', 'fPadraoBold');
        $textRun->addText('no que concerne aos honor??rios e atividades a serem exercidas.');

        $section -> addTextBreak(1);

        //DAS DESPESESAS
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DAS DESPESAS', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 4??. ', 'fPadraoBold');
        $textRun->addText('Todas as despesas efetuadas pela ');
        $textRun->addText('CONTRATADA, ', 'fPadraoBold');
        $textRun->addText('ligadas direta ou indiretamente com o processo, incluindo-se fotoc??pias, emolumentos, '
                            . 'viagens, custas, entre outros, ficar??o a cargo do ');
        $textRun->addText('CONTRATANTE.', 'fPadraoBold');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 5??. ', 'fPadraoBold');
        $textRun->addText('Todas as despesas ser??o acompanhadas de recibo, devidamente preparado e assinado pela ');
        $textRun->addText('CONTRATADA. ', 'fPadraoBold');

        $section -> addTextBreak(1);

        //DA COBRAN??A
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DA COBRAN??A', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 6??. ', 'fPadraoBold');
        $textRun->addText('As partes acordam que facultar?? a ');
        $textRun->addText('CONTRATADA, ', 'fPadraoBold');
        $textRun->addText('o direito de realizar a cobran??a dos honor??rios por todos os meios admitidos em direito.');

        $section -> addTextBreak(1);

        //DA HONOR??RIOS
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DOS HONOR??RIOS', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 7??. ', 'fPadraoBold');
        $textRun->addText('Fica acordado entre as partes que os honor??rios a t??tulo de presta????o de servi??os jur??dicos '
                            . 'objeto da Cl??usula 1?? do presente instrumento contratual, conforme or??amento enviado por '
                            . 'correspond??ncia eletr??nica nesta data, o ');

            if (isset($contratos->numParcelaContrato) && $contratos->numParcelaContrato == 0) {
                $textRun->addText('CONTRATANTE, ', 'fPadraoBold');
                $textRun->addText('dever?? pagar o valor de ');
                $textRun->addText('R$ ' . number_format($contratos->valorContrato, 2, ',', '.')
                                    . ' ( ' . $contratos->valorExteContrato . ' ), ', 'fPadraoBold');
                $textRun->addText('na data de');
                $textRun->addText(date('d/m/Y', strtotime($contratos->dataVencContrato)) . ' ', 'fPadraoBold');
                $textRun->addText('devendo ser realizado em uma das seguintes modalidades, dep??sito em dinheiro ou TED em Institui????o Financeira ');
                $textRun->addText('BANCO CAIXA ECONOMICA FEDERAL, AG??NCIA 2897, CONTA 796828921-2 OP1288, ', 'fPadraoBold');
                $textRun->addText('ou em esp??cie, cart??o de cr??dito ou d??bito em conta no escrit??rio da ');
                $textRun->addText('CONTRATADA', 'fPadraoBold');
                $textRun->addText(', podendo ainda ser custeado na modalidade descrita no ');
                $textRun->addText('??1??.', 'fPadraoBold');
            }

            if (isset($contratos->numParcelaContrato) && $contratos->numParcelaContrato > 0 && $contratos->valorEntradaContrato > 0) {
                $textRun->addText('CONTRATANTE, ', 'fPadraoBold');
                $textRun->addText('dever?? pagar o valor de ');
                $textRun->addText('R$ ' . number_format($contratos->valorContrato, 2, ',', '.')
                                    . ' ( ' . $contratos->valorExteContrato . ' ), ', 'fPadraoBold');
                $textRun->addText('sendo no ato da assinatura do contrato, uma entrada no valor de ');
                $textRun->addText('R$ ' . number_format($contratos->valorEntradaContrato, 2, ',', '.')
                                    . ' ( ' . $contratos->valorExteEntContrato . ' ), ', 'fPadraoBold');
                $textRun->addText('e o restante parcelado em ');
                $textRun->addText($contratos->numParcelaContrato . '( ' . $contratos->numParcelaExtenso . ' ) ', 'fPadraoBold');
                $textRun->addText('parcela(s) iguais, no valor de ');
                $textRun->addText('R$ ' .number_format($contratos->valorParcelaContrato, 2, ',', '.') . ' ( ' . $contratos->valorParcelaContratoExtenso . ' ) ', 'fPadraoBold');
                $textRun->addText('sendo o primeiro vencimento para o dia ');
                $textRun->addText(date("d/m/Y", strtotime($contratos->dataVencContrato)). ' ', 'fPadraoBold');

                if ($contratos->numParcelaContrato > 1) {
                    $textRun->addText('e as demais a cada 30 dias ap??s a parcela vencida, ');
                }

                $textRun->addText('devendo ser realizado em uma das seguintes modalidades, dep??sito em dinheiro ou TED '
                                    . 'em Institui????o Financeira ');
                $textRun->addText('BANCO CAIXA ECONOMICA FEDERAL, AG??NCIA 2897, CONTA 796828921-2 OP1288, ', 'fPadraoBold');
                $textRun->addText('ou em esp??cie, cart??o de cr??dito ou d??bito em conta no escrit??rio da ');
                $textRun->addText('CONTRATADA', 'fPadraoBold');
                $textRun->addText(', podendo ainda ser custeado na modalidade descrita no ');
                $textRun->addText('??1??.', 'fPadraoBold');
            }

            if (isset($contratos->numParcelaContrato) && $contratos->numParcelaContrato > 0 && $contratos->valorEntradaContrato == 0) {
                $textRun->addText('CONTRATANTE, ', 'fPadraoBold');
                $textRun->addText('dever?? pagar o valor de ');
                $textRun->addText('R$ ' . number_format($contratos->valorContrato, 2, ',', '.')
                                    . ' ( ' . $contratos->valorExteContrato . ' ), ', 'fPadraoBold');
                $textRun->addText('parcelado em ');
                $textRun->addText($contratos->numParcelaContrato . '( ' . $contratos->numParcelaExtenso . ' ) ', 'fPadraoBold');
                $textRun->addText('parcela(s) iguais, no valor de ');
                $textRun->addText('R$ ' .number_format($contratos->valorParcelaContrato, 2, ',', '.') . ' ( ' . $contratos->valorParcelaContratoExtenso . ' ) ', 'fPadraoBold');
                $textRun->addText('sendo o primeiro vencimento para o dia ');
                $textRun->addText(date("d/m/Y", strtotime($contratos->dataVencContrato)). ' ', 'fPadraoBold');

                if ($contratos->numParcelaContrato > 1) {
                    $textRun->addText('e as demais a cada 30 dias ap??s a parcela vencida, ');
                }

                $textRun->addText('devendo ser realizado em uma das seguintes modalidades, dep??sito em dinheiro ou TED '
                                    . 'em Institui????o Financeira ');
                $textRun->addText('BANCO CAIXA ECONOMICA FEDERAL, AG??NCIA 2897, CONTA 796828921-2 OP1288, ', 'fPadraoBold');
                $textRun->addText('ou em esp??cie, cart??o de cr??dito ou d??bito em conta no escrit??rio da ');
                $textRun->addText('CONTRATADA', 'fPadraoBold');
                $textRun->addText(', podendo ainda ser custeado na modalidade descrita no ');
                $textRun->addText('??1??.', 'fPadraoBold');
            }

        $textRun = $section->addTextRun('pPadraoTab');
        $textRun->addText('??1??. PIX: CHAVE: E-MAIL: DRCONSULTORIAJURIDICA.AM@GMAIL.COM.', 'fPadraoBoldSubli');

        $textRun = $section->addTextRun('pPadraoTab');
        $textRun->addText('??2??. EM CASO DE N??O PAGAMENTO DA PARCELA AT?? A DATA DO VENCIMENTO, O CONTRATANTE '
                            . 'PAGAR?? O VALOR DA PARCELA EM DOBRO, COMO INDENIZA????O POR PERDAS E DANOS.', 'fPadraoBold');

        $textRun = $section->addTextRun('pPadraoTab');
        $textRun->addText('??3??. CASO AS DATAS ACIMA ESTIPULADAS PARA PAGAMENTO NA CL??USULA 7??, '
                            . 'ocorram em finais de semana (s??bado/domingo) e/ou em feriados (nacionais, estaduais, municipais) '
                            . 'o CONTRATANTE ', 'fPadraoBold');
        $textRun->addText('obriga-se a custear o valor supra na data exata discriminada, devido as in??meras '
                            . 'possibilidades de pagamento, descritos no caput desta.');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 8??. ', 'fPadraoBold');
        $textRun->addText('Deixando motivadamente, de ter o patroc??nio deste caus??dico, ora contratado, o valor '
                            . 'prestado inicialmente na propositura da A????o reverter-se-?? em favor do mesmo, sem preju??zos de '
                            . 'posteriores cobran??as judiciais, em face do ');
        $textRun->addText('CONTRATANTE.', 'fPadraoBold');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 9??. ', 'fPadraoBold');
        $textRun->addText('Os honor??rios de sucumb??ncia pertencem ao ');
        $textRun->addText('CONTRATADO', 'fPadraoBold');
        $textRun->addText(', se estes houverem.');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Par??grafo ??nico ', 'fPadraoBold');
        $textRun->addText('Caso haja morte ou incapacidade civil da ');
        $textRun->addText('CONTRATADA', 'fPadraoBold');
        $textRun->addText(', seus herdeiros e sucessores ou representante legal receber??o os honor??rios '
                            . 'na propor????o do trabalho realizado.');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 10?? ', 'fPadraoBold');
        $textRun->addText('Havendo acordo entre o ');
        $textRun->addText('CONTRATANTE ', 'fPadraoBold');
        $textRun->addText('e a parte contr??ria, n??o prejudicar?? o recebimento dos honor??rios contratados '
                            . 'e honor??rios sucumbenciais, caso em que os hor??rios iniciais e finais ser??o pagos a ');
        $textRun->addText('CONTRATADA.', 'fPadraoBold');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 11?? ', 'fPadraoBold');
        $textRun->addText('As partes estabelecem que havendo atraso no pagamento sejam cobrados, PERDAS E DANOS em conformidade com os'
                            . '??1?? e ??2??, Cl??usula 7?? item ???DOS HONOR??RIOS???, e ainda cobrados, multa de 15% (quinze por cento) e juros de mora '
                            . 'na propor????o de 1% (um por cento) ao m??s, conforme art. 412 do C??digo Civil Brasileiro.');

        $section -> addTextBreak(1);

        //DA RESCIS??O
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DA RESCIS??O', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 12??. ', 'fPadraoBold');
        $textRun->addText('Agindo o ');
        $textRun->addText('CONTRATANTE ', 'fPadraoBold');
        $textRun->addText('e forma dolosa ou culposa em face da ');
        $textRun->addText('CONTRATADA', 'fPadraoBold');
        $textRun->addText(', restar?? '
                            . 'facultado a este, rescindir o contrato, substabelecendo sem reserva de iguais e se exonerando de todas '
                            . 'as obriga????es.');

        $section -> addTextBreak(1);

        //DO FORO
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('DO FORO', 'fPadraoBoldSubli');
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Cl??usula 13??. ', 'fPadraoBold');
        $textRun->addText('Para dirimir quaisquer controv??rsias oriundas do ');
        $textRun->addText('CONTRATO ', 'fPadraoBold');
        $textRun->addText(' as partes elegem o foro da Comarca de ' . $contratos->comarcaCidadeContrato . ' no estado do '
                            . $contratos->comarcaEstadoContrato . '.');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Por estarem assim justos e contratados, firmam o presente instrumento, em duas vias de igual teor, '
                            . 'dispensa testemunhas e assinaturas f??sicas, modalidade contratual virtual, com certifica????o de veracidade por ID e-mail Contratante e Contratado.');

        $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Manaus/AM, '. ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($contratos->created_at)))) . '.');

        $textRun = $section->addTextRun('pPadrao');
            $section->addText(
                '________________________________________________________________________',
                'fTituloCenter',
                'pTituloCenter'
            );                
            
            //$textRun = $section->addTextRun('pPadrao');
            $section->addText(
                'ASSINADO ELETRONICAMENTE',
                'fTituloCenter',
                'pTituloCenter'
            );

        $cont = count($contratos->Pessoa);

        foreach ($contratos->Pessoa as $pessoa) {            

            if ($pessoa->tipoPessoa == 1) {
                
                $table = $section->addTable();
                $table->addRow();
                $cellAssig = $table->addCell(5000);                                
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText($pessoa->nomeRazaoSocial, array('bold' => true ));
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText('CPF N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj), array('bold' => true ));

                $cellAssig = $table->addCell(5000);                                
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText('DANIELLE RUFINO ALVES RICARDO', array('bold' => true ));
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText('OAB/AM N?? 3643', array('bold' => true ));

            } else {
                $table = $section->addTable();
                $table->addRow();
                
                $cellAssig = $table->addCell(5000);                                
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText($pessoa->nomeRazaoSocial, array('bold' => true ));
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText('CNPJ N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj), array('bold' => true ));

                $cellAssig = $table->addCell(5000);                                
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText('DANIELLE RUFINO ALVES RICARDO', array('bold' => true ));
                $textrun = $cellAssig->addTextRun(array('alignment' => 'center', 'valign' => 'center'));
                $textrun->addText('OAB/AM N?? 3643', array('bold' => true ));
            }

            if ($cont > 1) {
                $section -> addTextBreak(1);
                $cont--;
            }

        }

        //$textRun = $section->addTextRun('pPadrao');
            $section->addText(
                '________________________________________________________________________',
                'fTituloCenter',
                'pTituloCenter'
            );

        $section -> addTextBreak(1);
        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Protegido pela Lei n?? 9.610, de 19/02/1998 - Lei de Direitos Autorais.', array('bold' => true, 'size' => '8', 'italic' => true));


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('DRHN' . $contratos->numContrato . '.docx'));

        return response()->download(storage_path('DRHN' . $contratos->numContrato . '.docx'));

    }

    function convertToHtml($contratosPdf)
    {
        $output = '
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta http-equiv="x-ua-compatible" content="ie=edge">
                <title>DRSis - Jur??dico</title>

                <link href="pdfGenerate/css/pdfCreate.css" rel="stylesheet">

            </head>

            <body>

                <header>
                    <div style="width: 100%;  margin-top: 30px;">
                        <div style="float: left; width: 10%">
                            <img src="imagens/logo_dr.png"  width="110px" height="90px"/>
                        </div>
                        <div style="float: left; width: 50%">
                            <h3 class="fontTituloCabecalho">

                            </h3>
                        </div>
                        <div style="float: right; width: 60%; font-size: .90rem;" >
                            <h5 class="text-right" >
                                <em>Dra. Danielle Rufino Alves Ricardo ??? OAB/AM 3643</em>
                            </h5>
                            <h5 class="text-right">
                                <em>OAB/RN 1324-A</em>
                            </h5>
                        </div>
                        <hr style="width: 100%; color: blue; height: 1px; background-color:blue; margin-top: 100px;">
                    </div>

                </header>

                <footer>
                    <p class="text-right">

                        ___________________________________________ <br>
                        <em> Assinatura Contratante
                        <em>
                    </p>
                    <hr style="width: 100%; color: blue; height: 1px; background-color:blue;">
                    <div style="width: 100%;  margin-top: 30px;">
                        <div style="float: rigth; width: 100%; font-size: .90rem;">
                            <h5 class="text-right">
                                <em>Rua Val??ncia, n?? 2, Q/64, Conj. Campos Eliseos ??? Planalto, CEP: 69045-560. MAO/AM</em>
                            </h5>
                            <h5 class="text-right">
                                <em>Email: danielle.adv@hotmail.com</em>
                            </h5>
                        </div>
                    </div>
                </footer>


            <div class="card-body">';
        if (isset($contratosPdf)) {
            $output .= '<div px-4 py-2>

                <div class="content-header">
                    <h1 class="text-center"><strong>CONTRATO HONOR??RIOS ADVOCAT??CIOS N?? DRHN_' . $contratosPdf->numContrato . '</strong></h1>
                    <br>
                </div>

                <div class="content px-2">
                    <hr>
                    <u>
                        <br>
                        <h5 class="text-bold text-center"><strong>IDENTIFICA????O DAS PARTES CONTRATANTES</strong></h5>
                        <br>
                    </u>';

            foreach ($contratosPdf->Pessoa as $pessoa) {

                if ($pessoa->tipoPessoa == 1) {
                    $output .= '<p class="text-justify"> <strong> CONTRATANTE: ' . $pessoa->nomeRazaoSocial . '</strong>, ' . $pessoa->nacionalidade . ', ' . $pessoa->profissao . ',  portador do RG
                               N?? ' . $pessoa->rg . ' ' . $pessoa->orgExpedidor . '/' . $pessoa->ufOrgExpedidor . ',  CPF N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) . ' com endere??o nesta Cidade na ' . $pessoa->logradouro . ',
                               N?? ' . $pessoa->numero . ', ' . (isset($pessoa->complemento) ? $pessoa->complemento . " - " : "") . ' ' . $pessoa->bairro . ', CEP: ' . $pessoa->cep . ' e-mail: ' . $pessoa->email . '</p>';
                } else {
                    $output .= '<p class="text-justify"> <strong> CONTRATANTE: ' . $pessoa->nomeRazaoSocial . ' </strong>, devidamente inscrita sob o
                                CNPJ ' .ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) . ' (Doc Digitalizado), registrada na Junta Comercial do Estado do Amazonas
                                NIRE n?? ' . $pessoa->nire . ', estabelecida na ' . $pessoa->logradouro . ', N?? ' . $pessoa->numero . ', ' . (isset($pessoa->complemento) ? $pessoa->complemento . " - " : "") . ' ' . $pessoa->bairro . ', CEP: ' . $pessoa->cep . ' neste ato
                                representado pelo Sr. <strong> ' . $pessoa->nomeRepresentante . '</strong>, ' . $pessoa->nacionalidadeRepresentante . ', ' . $pessoa->profissaoRepresentante . ', portador do RG
                                N?? ' . $pessoa->rgRepresentante . ' ' . $pessoa->orgExpedidorRepresentante . '/' . $pessoa->ufOrgExpedidorRepresentante . ', CPF N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfRepresentante) . 'com endere??o nesta Cidade na
                                ' . $pessoa->logradouroRepresentante . ', N?? ' . $pessoa->numeroRepresentante . ', ' . (isset($pessoa->complementoRepresentante) ? $pessoa->complementoRepresentante . " - " : "") . ' ' . $pessoa->bairroRepresentante . ', CEP: ' . $pessoa->cepRepresentante . 'e-mail: ' . $pessoa->emailRepresentante . '</p>';
                }
            }

            $output .= '
                    <br>
                    <p class="text-justify">
                        <strong>CONTRATADA: Dra. DANIELLE RUFINO ALVES RICARDO</strong>, brasileira, casada, Advogada, inscrita
                        regularmente na Ordem dos Advogados do Brasil, Se????o/AM sob o n.?? 3.643, Se????o/RN sob o n??mero n.??
                        1324-A com escrit??rio profissional na Cidade de Manaus/AM ?? Rua Val??ncia, n?? 02, Q/64, Conj. Campos
                        Eliseos - Planalto, CEP: 69045-560. E-mail: atendimento@drconsultoriajur??dica.com; cel(92)98191-8315
                    </p>
                    <hr>

                    <br>

                    <p class="text-justify"><strong><em>As partes acima identificadas t??m, entre si, justo e acertado o presente Contrato de Honor??rios
                        Advocat??cios, que se reger?? pelas cl??usulas seguintes e pelas condi????es descritas no presente.</em></strong>
                    </p>
                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><strong><u>DO OBJETO DO CONTRATO</u></strong></h5>
                        <strong>Cl??usula 1??.</strong> O presente instrumento tem como OBJETO a presta????o de servi??os advocat??cios referentes
                        a <strong>' . $contratosPdf->objetoContrato . '.</strong>
                    </p>

                    <br>
                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><u>DAS ATIVIDADES</u></h5>
                        <strong>Cl??usula 2??.</strong> As atividades inclusas na presta????o de servi??o objeto deste instrumento s??o todas aquelas
                        inerentes ?? profiss??o, quais sejam:
                    </p>

                        <p class="text-justify recuo">
                            <strong>a)</strong> Praticar quaisquer atos e medidas necess??rias e inerentes ?? causa, em todas as reparti????es
                            p??blicas da Uni??o, dos Estados ou dos Munic??pios, bem como ??rg??os a estes ligados direta ou
                            indiretamente, seja por delega????o, concess??o ou outros meios, bem como de estabelecimentos
                            particulares.
                        </p>
                        <p class="text-justify recuo">
                            <strong>b)</strong> Praticar todos os atos inerentes ao exerc??cio da advocacia e aqueles constantes no Estatuto da
                            Ordem dos Advogados do Brasil, bem como os especificados no Instrumento Procurat??rio.
                        </p>

                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><u>DOS ATOS PROCESSUAIS</u></h5>
                        <strong>Cl??usula 3??.</strong> Havendo necessidade de contrata????o de outros profissionais, no decurso do processo, a
                        <strong>CONTRATADA</strong> elaborar?? substabelecimento, indicando escrit??rio de seu conhecimento, restando
                        facultado ao <strong>CONTRATANTE</strong> aceit??-lo ou n??o. Aceitando, ficar?? sob a responsabilidade, ??nica e
                        exclusivamente do <strong>CONTRATANTE</strong> no que concerne aos honor??rios e atividades a serem exercidas.
                    </p>

                    <br>
                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><u>DAS DESPESAS</u></h5>
                        <strong>Cl??usula 4??.</strong> Todas as despesas efetuadas pela <strong>CONTRATADA</strong>, ligadas direta ou indiretamente com o
                        processo, incluindo-se fotoc??pias, emolumentos, viagens, custas, entre outros, ficar??o a cargo do
                        <strong>CONTRATANTE</strong>.
                    </p>
                    <p class="text-justify">
                        <strong>Cl??usula 5??.</strong> Todas as despesas ser??o acompanhadas de recibo, devidamente preparado e assinado
                        pela <strong>CONTRATADA</strong>.
                    </p>

                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><u>DA COBRAN??A</u></h5>
                        <strong>Cl??usula 6??.</strong> As partes acordam que facultar?? a <strong>CONTRATADA</strong>, o direito de realizar a cobran??a dos
                        honor??rios por todos os meios admitidos em direito.
                    </p>

                    <br>
                    <br>

                    <p class="text-justify">
                    <h5 class="text-bold "><u>DOS HONOR??RIOS</u></h5>
                        <strong>Cl??usula 7??.</strong> Fica acordado entre as partes que os honor??rios a t??tulo de presta????o de servi??os jur??dicos
                        objeto da Cl??usula 1?? do presente instrumento contratual, conforme or??amento enviado por
                        correspond??ncia eletr??nica nesta data,';

            if (isset($contratosPdf->numParcelaContrato) && $contratosPdf->numParcelaContrato == 0) {
                $output .= 'o <strong>CONTRATANTE</strong> dever?? pagar o valor de <strong>R$ ' . number_format($contratosPdf->valorContrato, 2, ',', '.') .
                    '( ' . $contratosPdf->valorExteContrato . ' )</strong> na data de <strong>' . date('d/m/Y', strtotime($contratosPdf->dataVencContrato)) . '</strong>
                            devendo ser realizado em uma das seguintes modalidades, dep??sito em dinheiro ou TED em Institui????o Financeira
                            <strong>BANCO ITA??, AG??NCIA 7163, CONTA 31843-4</strong>, ou em esp??cie, cart??o de cr??dito ou d??bito em conta no escrit??rio da <strong>CONTRATADA</strong>.';
            }

            if (isset($contratosPdf->numParcelaContrato) && $contratosPdf->numParcelaContrato > 0 && $contratosPdf->valorEntradaContrato > 0) {
                $output .= 'o <strong>CONTRATANTE</strong> dever?? pagar o valor de <strong>R$ ' . number_format($contratosPdf->valorContrato, 2, ',', '.') .
                    '( ' . $contratosPdf->valorExteContrato . ' )</strong> sendo no ato da assinatura do contrato uma entrada no valor de <strong>R$ ' . number_format($contratosPdf->valorEntradaContrato, 2, ',', '.') .
                    '( ' . $contratosPdf->valorExteEntContrato . ' )</strong> e o restante parcelado em <strong> ' . $contratosPdf->numParcelaContrato . '( ' . $contratosPdf->numParcelaExtenso . ' )</strong>
                            parcela(s) iguais, no valor de <strong>R$ ' . number_format($contratosPdf->valorParcelaContrato, 2, ',', '.') . ' ( ' . $contratosPdf->valorParcelaContratoExtenso . ' )</strong> sendo o primeiro vencimento para o dia <strong>' . date("d/m/Y", strtotime($contratosPdf->dataVencContrato)) . '</strong>';

                if ($contratosPdf->numParcelaContrato > 1) {
                    $output .= 'e as demais a cada 30 dias ap??s a parcela vencida,';
                }

                $output .= 'devendo ser realizado em uma das seguintes modalidades, dep??sito em dinheiro ou TED em Institui????o Financeira
                            <strong>BANCO ITA??, AG??NCIA 7163, CONTA 31843-4</strong>, ou em esp??cie, cart??o de cr??dito ou d??bito em conta no escrit??rio da <strong>CONTRATADA</strong>.';
            }

            if (isset($contratosPdf->numParcelaContrato) && $contratosPdf->numParcelaContrato > 0 && $contratosPdf->valorEntradaContrato == 0) {
                $output .= 'o <strong>CONTRATANTE</strong> dever?? pagar o valor de <strong>R$ ' . number_format($contratosPdf->valorContrato, 2, ',', '.') .
                    '( ' . $contratosPdf->valorExteContrato . ' )</strong> parcelado em <strong>' . $contratosPdf->numParcelaContrato . ' ( ' . $contratosPdf->numParcelaExtenso . ' )</strong>
                            parcela(s) iguais, no valor de <strong>R$ ' . number_format($contratosPdf->valorParcelaContrato, 2, ',', '.') . ' ( ' . $contratosPdf->valorParcelaContratoExtenso . ' )</strong> sendo o primeiro vencimento para o dia <strong>' . date("d/m/Y", strtotime($contratosPdf->dataVencContrato)) . '</strong> ';
                if ($contratosPdf->numParcelaContrato > 1) {
                    $output .= 'e as demais a cada 30 dias ap??s a parcela vencida,';
                }
                $output .= 'devendo ser realizado em uma das seguintes modalidades, dep??sito em dinheiro ou TED em Institui????o Financeira
                            <strong>BANCO ITA??, AG??NCIA 7163, CONTA 31843-4</strong>, ou em esp??cie, cart??o de cr??dito ou d??bito em conta no escrit??rio da <strong>CONTRATADA</strong>.';
            }

            $output .=
                '</p>
                    <p class="text-justify recuo">
                        <strong>??1??. EM CASO DE N??O PAGAMENTO DA PARCELA AT?? A DATA DO VENCIMENTO, O CONTRATANTE
                        PAGAR?? O VALOR DA PARCELA EM DOBRO, COMO INDENIZA????O POR PERDAS E DANOS.</strong>
                    </p>
                    <p class="text-justify recuo">
                        <strong>??2??. CASO AS DATAS ACIMA ESTIPULADAS PARA PAGAMENTO NA CL??USULA 7??,
                        ocorram em finais de semana (s??bado/domingo) e/ou em feriados(nacionais/estaduais/municipais)
                        o CONTRATANTE</strong> obriga-se a custear o valor supra na data exata discriminada, devido as in??meras
                        possibilidades de pagamento, descritos no caput desta.
                    </p>
                    <p class="text-justify recuo">
                        <strong>??3??. Nas modalidades de pagamento (d??bito e cr??dito)ainda que parcelado,
                        o CONTRATANTE assumir?? os juros da operadora do cart??o.</strong>
                    </p>
                    <p class="text-justify">
                        <strong>Cl??usula 8??.</strong> Deixando motivadamente, de ter o patroc??nio deste caus??dico, ora contratado, o valor
                        prestado inicialmente na propositura da A????o reverter-se-?? em favor do mesmo, sem preju??zos de
                        posteriores cobran??as judiciais, em face do <strong>CONTRATANTE</strong>.
                    </p>
                    <p class="text-justify">
                        <strong>Cl??usula 9??.</strong> Os honor??rios de sucumb??ncia pertencem ao <strong>CONTRATADO</strong>, se estes houverem.
                    </p>
                    <p class="text-justify">
                        <strong>Par??grafo ??nico</strong>. Caso haja morte ou incapacidade civil da <strong>CONTRATADA</strong>, seus herdeiros e sucessores
                        ou representante legal receber??o os honor??rios na propor????o do trabalho realizado.
                    </p>
                    <p class="text-justify">
                        <strong>Cl??usula 10??.</strong> Havendo acordo entre o <strong>CONTRATANTE</strong> e a parte contr??ria, n??o prejudicar?? o
                        recebimento dos honor??rios contratados e honor??rios sucumbenciais, caso em que os hor??rios iniciais e
                        finais ser??o pagos a <strong>CONTRATADA</strong>.
                    </p>
                    <p class="text-justify">
                        <strong>Cl??usula 11??.</strong>As partes estabelecem que havendo atraso no pagamento sejam cobrados, PERDAS E
                        DANOS em conformidade com os ??1?? e ??2??, Cl??usula 7?? item ???DOS HONOR??RIOS???, e ainda cobrados,
                         multa de 15% (quinze por cento) e juros de mora na propor????o de 1% (um por cento) ao m??s, conforme art. 412 do C??digo Civil Brasileiro.
                    </p>

                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><u>DA RESCIS??O</u></h5>
                        <strong>Cl??usula 12??</strong>. Agindo o <strong>CONTRATANTE</strong> de forma dolosa ou culposa em face da <strong>CONTRATADA</strong>, restar??
                        facultado a este, rescindir o contrato, substabelecendo sem reserva de iguais e se exonerando de todas
                        as obriga????es.
                    </p>

                    <br>
                    <br>

                    <p class="text-justify">
                        <h5 class="text-bold "><u>DO FORO</u></h5>
                        <strong>Cl??usula 13??</strong>. Para dirimir quaisquer controv??rsias oriundas do <strong>CONTRATO</strong>, as partes elegem o foro da
                        Comarca de ' . $contratosPdf->comarcaCidadeContrato . ' no estado do ' . $contratosPdf->comarcaEstadoContrato . '.
                    </p>
                    <p class="text-justify">
                        Por estarem assim justos e contratados, firmam o presente instrumento, em duas vias de igual teor,
                        juntamente com 2 (duas) testemunhas.

                    </p>

                    <br>

                    <p class="text-left">
                        Manaus/AM, ' .
                        ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($contratosPdf->created_at))))
                . '</p>
                    <br>
                    <br>
                    <br>';

            foreach ($contratosPdf->Pessoa as $pessoa) {

                if ($pessoa->tipoPessoa == 1) {
                    $output .=
                        '<p class="text-justify">
                            _________________________________________ <br><strong>'
                            . $pessoa->nomeRazaoSocial .
                            '<br> CPF N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) .
                            '<br><br></strong>
                        </p>';
                } else {
                    $output .=
                        '<p class="text-justify">
                            _________________________________________ <br><strong>'
                            . $pessoa->nomeRazaoSocial .
                            '<br> CNPJ ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) .
                        '</p>';
                }
            }

            $output .= '
                    </p>
                    <br>
                    <p class="text-justify">
                        <strong>_________________________________________ <br>
                        Danielle Rufino Alves Ricardo
                        <br> OAB/AM N?? 3643
                        </strong>
                        <br>
                        <br>
                        <p style="font-size: 0.50rem">
                            <em>Protegido pela Lei n?? 9.610, de 19/02/1998 - Lei de Direitos Autorais</em>
                        </p>
                    </p>
                </div>
                <br>

            </div>';
        }
        $output .=
            '</div>

            </body>
            </html>';

        return $output;
    }
}
