<?php

namespace App\Http\Controllers;

use App\Entities\ReciboControle;
use App\Entities\ReciboQuitacaoControlhe;
use \App\Entities\FormaPagamento;
use App\Entities\FormaPagamentoParcela;
use App\Http\Requests\ContasReceberUpdateRequest;
use App\Repositories\ContasReceberRepository;
use App\Exceptions\ExceptionsErros;
use App\Funcoes\ConvertNumeroTexto;
use App\Http\Requests\ContasReceberCreateRequest;
use App\Repositories\ContratoRepository;
use App\Repositories\FormaPagamentoRepository;
use App\Repositories\FormaPagamentoParcelaRepository;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class ContasRecebersController extends Controller
{
    protected $repository;
    protected $erros;
    protected $contratoRepository;
    protected $reciboRepository;
    protected $reciboQuitacaoRepository;
    protected $formaPagamento;
    protected $formaPagamentoParcela;

    public function __construct(ContasReceberRepository $repository,
                                ExceptionsErros $erros,
                                ContratoRepository $contratoRepository,
                                ReciboControle $reciboRepository,
                                ReciboQuitacaoControlhe $reciboQuitacaoRepository,
                                FormaPagamentoRepository $formaPagamento,
                                FormaPagamentoParcelaRepository $formaPagamentoParcela )
    {
        $this->repository = $repository;
        $this->erros = $erros;
        $this->contratoRepository = $contratoRepository;
        $this->reciboRepository = $reciboRepository;
        $this->reciboQuitacaoRepository = $reciboQuitacaoRepository;
        $this->formaPagamento = $formaPagamento;
        $this->formaPagamentoParcela = $formaPagamentoParcela;
    }

    public function index()
    {
        $contParcelas = 0;
        $contasReceber = $this->contratoRepository->all()->where('statusContrato', 1);

        $teste = 0;

        foreach ($contasReceber as $contas) {

            foreach ($contas->ContasReceber->where('statusRecebimento', 1) as $cont) {
                $contas['valorReceber'] += $cont->valorParcela - $cont->valorRecebido;
                $teste = $contas['valorReceber'];
            }

            foreach ($contas->ContasReceber->where('statusRecebimento', 0) as $cont) {

                $contas['valorPago'] += $cont->valorRecebido;

                if ($cont->numeroParcela > 0)
                    $contParcelas = $contParcelas + 1;
            }

            if ($contas->numParcelaContrato == $contParcelas) {
                $this->contratoRepository->update([
                    'statusContrato' => 0
                ], $contas->id);

                $contParcelas = 0;
            }

            $contParcelas = 0;
        }

        return view('admin.contas_receber.index', compact('contasReceber'));
    }

    public function contasRecebidas()
    {
        $contParcelas = 0;
        $contasRecebidas = $this->contratoRepository->all()->where('statusContrato', 0);

        foreach ($contasRecebidas as $contas)
        {
            foreach ($contas->ContasReceber->where('statusRecebimento', 1) as $cont){
                $contas['valorReceber'] + $cont->valorParcela - $cont->valorRecebido;
            }

            foreach ($contas->ContasReceber->where('statusRecebimento', 0) as $cont){
                $contas['valorPago'] += $cont->valorRecebido;
                if ($cont->numeroParcela > 0)
                    $contParcelas = $contParcelas + 1;
            }

            $contParcelas = 0;
        }

        return view('admin.contas_recebidas.index', compact('contasRecebidas'));
    }
    public function contasReceberContrato($id, $dataVencimentoEntrada)
    {
        try {

            $contrato = $this->contratoRepository->find($id);

            if ($contrato->valorEntradaContrato > 0 || $contrato->numParcelaContrato == 0) {

                $contasReceberEntrada = [
                    'contrato_id'       => $contrato->id,
                    'valorParcela'      => $contrato->valorEntradaContrato,
                    'dataVencimento'    => $dataVencimentoEntrada,
                    'numeroParcela'     => 0,
                    'statusRecebimento' => 1
                ];

                $this->repository->create($contasReceberEntrada);
            }

            if($contrato->numParcelaContrato > 0) {

                $valorParcela = ($contrato->valorContrato - $contrato->valorEntradaContrato) / $contrato->numParcelaContrato;

                $dataVencimento = $contrato->dataVencContrato;

                for ($i = 1; $i <= $contrato->numParcelaContrato; $i++) {

                    if ($i > 1) {
                        $dataVencimento = date('Y-m-d', strtotime('+30 days', strtotime($dataVencimento)));
                    } else {
                        $dataVencimento = date('Y-m-d', strtotime($dataVencimento));
                    }

                    $contasReceber = [
                        'contrato_id'       => $contrato->id,
                        'valorParcela'      => $valorParcela,
                        'dataVencimento'    => $dataVencimento,
                        'numeroParcela'     => $i,
                        'statusRecebimento' => 1
                    ];

                    $contasReceber = $this->repository->create($contasReceber);
                }
            }

            session()->flash('success', [
                'success' => true,
                'messages' => 'Contrato Gerado com Sucesso'
            ]);

            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            return  $this->erros->errosExceptions($e);
        }

        return response()->json($contasReceber);
    }

    public function PagarParcela($id)
    {
        $parcelas = $this->repository->all()->where('contrato_id', $id);

        //dd(count($parcelas[55]->FormaPagamento));

        $formaPagamento = FormaPagamento::pluck('descricao', 'id');

        // Calcula a diferen??a em segundos entre as datas
        foreach ($parcelas as $parcela) {

            if (date('Y-m-d') > $parcela->dataVencimento && $parcela->statusRecebimento == 1) {
                $parcela['valorParcelaJuros'] = ConvertNumeroTexto::calculaJuros($parcela->dataVencimento, $parcela->valorParcela * 2);
            } else {
                $parcela['valorParcelaJuros'] = $parcela->valorParcela;
            }

            //PEGAR NUMERO DO CONTRATO
            $numContrato = $parcela->Contrato->numContrato;
            $cliente = $parcela->Contrato->Pessoa[0]->nomeRazaoSocial;
        };


        return view('admin.contas_receber.parcelas', compact('parcelas', 'numContrato', 'cliente', 'formaPagamento'));
    }

    public function finalizarPagamento(ContasReceberCreateRequest $request)
    {
        $contasReceber = $this->repository->update($request->except('tipoPagamento'), $request->id);

        $dados = [
            'parcela_id'            => $contasReceber->id,
            'forma_pagamento_id'    => $request->tipoPagamento
        ];

        $this->formaPagamentoParcela->create($dados);

        $recibo = [
            'contas_receber_id' => $contasReceber->id
        ];

        $this->reciboRepository->create($recibo);

        session()->flash('success', [
            'success' => true,
            'messages' => 'Parcela Paga Com Sucesso'
        ]);

        return redirect()->back();
    }

    public function imprimirRecibo($id)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $recibo = $this->repository->find($id);

        $recibo['valorParcelaExtenso'] = ConvertNumeroTexto::valorPorExtenso(number_format($recibo->valorRecebido, 2, ',', '.'), true, false);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addParagraphStyle('pBody', array('alignment' => 'left'));
        $phpWord->addParagraphStyle('pRight', array('alignment' => 'right'));
        $phpWord->addFontStyle('fBody', array('name' => 'arial', 'size' => 13, 'bold' => true));
        $phpWord->addFontStyle('fBodyItalic', array('name' => 'arial', 'size' => 13, 'bold' => true, 'italic' => true, 'underline' => 'single', 'bgColor' => 'ccccff'));
        $phpWord->addFontStyle('fBodyItalicData', array('name' => 'arial', 'size' => 13, 'bold' => true, 'italic' => true));
        $lineStyle = array('weight' => 1, 'width' => 460, 'height' => 2, 'color' => 'blue');

        $section = $phpWord->addSection();

        $table = $section->addTable('pRight');
        $table->addRow();
        $table->addCell(2500, array('borderBottomSize' => 12))->addImage(
            'imagens/logo_dr.png',
            array('width' => 60, 'height' => 40, 'align' => 'left')
        );

        $cell = $table->addCell(4500, array('borderBottomSize' => 12));
        $textrun = $cell->addTextRun('pBody');
        $textrun->addText('DR. Consultoria Jur??dica', array('name' => 'arial', 'bold' => true, 'size' => 10, 'italic' => true, 'color' => 'blue'));
        $textrun = $cell->addTextRun('pBody');
        $textrun->addText('Rua Val??ncia, 02, Campos Eliseos ??? Planalto. CEP: 69045-560. Fones: +55 (92) 98191-8315 (whatsapp).', array('name' => 'arial', 'size' => 6));

        $cell = $table->addCell(3500, array('borderLeftSize' => 12, 'borderBottomSize' => 12));
        $textrun = $cell->addTextRun(array('alignment' => 'right'));
        $textrun->addText('Recibo ', array('italic' => true, 'size' => 15, 'bold' => true));
        $textrun->addText('N?? ' . str_pad(($recibo->Recibo->id), 3, 0, STR_PAD_LEFT) . '/' . date('Y'), array('italic' => true, 'size' => 12, 'bold' => true));

        $textrun = $cell->addTextRun(array('alignment' => 'right'));
        $textrun->addText('R$ ' . number_format($recibo->valorRecebido, 2, ',', '.'), array('italic' => true, 'size' => 15, 'bold' => true));



        $section->addTextBreak(1);

        $textRun = $section->addTextRun('pBody');
        if($recibo->Contrato->Pessoa->count() > 1){

            $textRun->addText('Recebi dos Srs.(as) ', 'fBody');
        } else {
            $textRun->addText('Recebi do Sr.(a) ', 'fBody');
        }

        foreach ($recibo->Contrato->Pessoa as $pessoa) {
            $textRun->addText($pessoa->nomeRazaoSocial . ' - CPF/CNPJ N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj), 'fBodyItalic');

            if($recibo->Contrato->Pessoa->count() > 1)
                $textRun->addText(' | ', 'fBodyItalic');
        }

        $textRun = $section->addTextRun('pBody');
        $textRun->addText('a import??ncia de, ', 'fBody');
        $textRun->addText(strtoupper($recibo->valorParcelaExtenso), 'fBodyItalic');

        $textRun = $section->addTextRun('pBody');
        $textRun->addText('referente a(o) ', 'fBody');

        if($recibo->numeroParcela == 0){
            $textRun->addText('entrada do Contrato de Honor??rios N?? ' . $recibo->Contrato->numContrato, 'fBodyItalic');
        } else {
            $textRun->addText('Contrato de Honor??rios N?? ' . $recibo->Contrato->numContrato . ' - Parcela ' . $recibo->numeroParcela . '/' . $recibo->Contrato->numParcelaContrato, 'fBodyItalic');
        }

        $section->addTextBreak(2);

        $textRun = $section->addTextRun('pRight');
        $textRun->addText('Manaus/AM, '. ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($recibo->dataRecebimento)))) . '.', 'fBodyItalicData' );

        $section->addTextBreak(1);

        $textRun = $section->addTextRun('pRight');
        $textRun->addText('Dra. Danielle Rufino A. Ricardo', 'fBody');

        $textRun = $section->addTextRun('pRight');
        $textRun->addText('OAB AM/RN 3643/1324-A', 'fBodyItalicData');

        $section->addTextBreak(1);

        $textRun = $section->addTextRun();
        $textRun->addLine($lineStyle);

       //---------------------------------------------------------------------------------

       $table = $section->addTable('pRight');
       $table->addRow();
       $table->addCell(2500, array('borderBottomSize' => 12))->addImage(
           'imagens/logo_dr.png',
           array('width' => 60, 'height' => 40, 'align' => 'left')
       );

       $cell = $table->addCell(4500, array('borderBottomSize' => 12));
       $textrun = $cell->addTextRun('pBody');
       $textrun->addText('DR. Consultoria Jur??dica', array('name' => 'arial', 'bold' => true, 'size' => 10, 'italic' => true, 'color' => 'blue'));
       $textrun = $cell->addTextRun('pBody');
       $textrun->addText('Rua Val??ncia, 02, Campos Eliseos ??? Planalto. CEP: 69045-560. Fones: +55 (92) 98191-8315 (whatsapp).', array('name' => 'arial', 'size' => 6));

       $cell = $table->addCell(3500, array('borderLeftSize' => 12, 'borderBottomSize' => 12));
       $textrun = $cell->addTextRun(array('alignment' => 'right'));
       $textrun->addText('Recibo ', array('italic' => true, 'size' => 15, 'bold' => true));
       $textrun->addText('N?? ' . str_pad(($recibo->Recibo->id), 3, 0, STR_PAD_LEFT) . '/' . date('Y'), array('italic' => true, 'size' => 12, 'bold' => true));

       $textrun = $cell->addTextRun(array('alignment' => 'right'));
       $textrun->addText('R$ ' . number_format($recibo->valorRecebido, 2, ',', '.'), array('italic' => true, 'size' => 15, 'bold' => true));



       $section->addTextBreak(1);

       $textRun = $section->addTextRun('pBody');
       if($recibo->Contrato->Pessoa->count() > 1){

           $textRun->addText('Recebi dos Srs.(as) ', 'fBody');
       } else {
           $textRun->addText('Recebi do Sr.(a) ', 'fBody');
       }

       foreach ($recibo->Contrato->Pessoa as $pessoa) {
           $textRun->addText($pessoa->nomeRazaoSocial . ' - CPF/CNPJ N?? ' . ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj), 'fBodyItalic');

           if($recibo->Contrato->Pessoa->count() > 1)
               $textRun->addText(' | ', 'fBodyItalic');
       }

       $textRun = $section->addTextRun('pBody');
       $textRun->addText('a import??ncia de, ', 'fBody');
       $textRun->addText(strtoupper($recibo->valorParcelaExtenso), 'fBodyItalic');

       $textRun = $section->addTextRun('pBody');
       $textRun->addText('referente a(o) ', 'fBody');

       if($recibo->numeroParcela == 0){
           $textRun->addText('entrada do Contrato de Honor??rios N?? ' . $recibo->Contrato->numContrato, 'fBodyItalic');
       } else {
           $textRun->addText('Contrato de Honor??rios N?? ' . $recibo->Contrato->numContrato . '  - Parcela ' . $recibo->numeroParcela . '/' . $recibo->Contrato->numParcelaContrato, 'fBodyItalic');
       }

       $section->addTextBreak(2);

       $textRun = $section->addTextRun('pRight');
       $textRun->addText('Manaus/AM, '. ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($recibo->dataRecebimento)))) . '.', 'fBodyItalicData' );

       $section->addTextBreak(1);

       $textRun = $section->addTextRun('pRight');
       $textRun->addText('Dra. Danielle Rufino A. Ricardo', 'fBody');

       $textRun = $section->addTextRun('pRight');
       $textRun->addText('OAB AM/RN 3643/1324-A', 'fBodyItalicData');


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('RECIBO_' .str_pad(($recibo->Recibo->id), 3, 0, STR_PAD_LEFT) . '_' . date('Y') . '.docx'));

        return response()->download(storage_path('RECIBO_' .str_pad(($recibo->Recibo->id), 3, 0, STR_PAD_LEFT) . '_' . date('Y') . '.docx'));

    }

    public function imprimirReciboQuitacao($id)
    {

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $reciboQuitacao = $this->reciboQuitacaoRepository->all()->where('contrato_id', $id);
        if ($reciboQuitacao->count() == 0) {
            $reciboQuitacaoNovo = [
                'contrato_id' => $id
            ];

            $this->reciboQuitacaoRepository->create($reciboQuitacaoNovo);
        }

        $contrato = $this->contratoRepository->find($id);


        //$recibo['valorContratoExtenso'] = ConvertNumeroTexto::valorPorExtenso(number_format($recibo->Contrato->valorContrato, 2, ',', '.'), true, false);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addParagraphStyle('pBody', array('align' => 'left', 'lineHeight' => 1.5));
        $phpWord->addParagraphStyle('pRight', array('alignment' => 'right'));
        $phpWord->addFontStyle('fBody', array('name' => 'arial', 'size' => 12, 'bold' => false));
        $phpWord->addFontStyle('fBodyCaps', array('name' => 'arial', 'size' => 12, 'allCaps' => true));
        $phpWord->addFontStyle('fBodyItalic', array('name' => 'arial', 'size' => 12, 'bold' => true, 'italic' => false));
        $phpWord->addFontStyle('fBodyItalicData', array('name' => 'arial', 'size' => 12, 'bold' => true, 'italic' => true));
        $lineStyle = array('weight' => 1, 'width' => 460, 'height' => 2, 'color' => 'blue');

        $section = $phpWord->addSection();

        $table = $section->addTable('pRight');
        $table->addRow();
        $table->addCell(1500, array('borderBottomSize' => 12))->addImage(
            'imagens/logo_dr.png',
            array('width' => 60, 'height' => 40, 'align' => 'left')
        );

        $cell = $table->addCell(5500, array('borderBottomSize' => 12));
        $textrun = $cell->addTextRun('pBody');
        $textrun->addText('DR. Consultoria Jur??dica', array('name' => 'arial', 'bold' => true, 'size' => 11, 'italic' => true, 'color' => 'blue'));
        $textrun = $cell->addTextRun('pBody');
        $textrun->addText('Rua Val??ncia, 02, Campos Eliseos ??? Planalto. CEP: 69045-560. Fones: +55 (92) 98191-8315 (whatsapp).', array('name' => 'arial', 'size' => 9));

        $cell = $table->addCell(3500, array('borderLeftSize' => 12, 'borderBottomSize' => 12));
        $textrun = $cell->addTextRun(array('alignment' => 'right'));
        $textrun->addText('Recibo ', array('italic' => true, 'size' => 18, 'bold' => true));
        $textrun->addText('Quita????o', array('italic' => true, 'size' => 12, 'bold' => true));

        $textrun = $cell->addTextRun(array('alignment' => 'right'));
        $textrun->addText('N?? ' . str_pad(($contrato->ReciboQuitacaoControlhe->id), 3, 0, STR_PAD_LEFT) . '/' . date('Y'), array('italic' => true, 'size' => 12, 'bold' => true));

        $textrun = $cell->addTextRun(array('alignment' => 'right'));
        $textrun->addText('R$ ' . number_format($contrato->valorContrato, 2, ',', '.'), array('italic' => true, 'size' => 15, 'bold' => true));

        $section->addTextBreak(1);

        $textRun = $section->addTextRun('pBody');
        if($contrato->Pessoa->count() > 1){

            $textRun->addText('Recebi dos Srs.(as) ', 'fBody');
        } else {
            $textRun->addText('Recebi do Sr.(a) ', 'fBody');
        }

        foreach ($contrato->Pessoa as $pessoa) {
            $textRun->addText($pessoa->nomeRazaoSocial . ',', 'fBodyItalic');
            $textRun->addText(' ' . $pessoa->nacionalidade . ', ' . $pessoa->profissao . ', ' . $pessoa->estadoCivil . ' portador da C??dula de identidade RG n?? ' .
            '' . $pessoa->rg . ' ' . $pessoa->orgExpedidor . '/' . $pessoa->ufOrgExpedidor .' do CPF/CNPJ N?? ' .
            '' .ConvertNumeroTexto::formatCnpjCpf($pessoa->cpfCnpj) . ',', 'fBody');

            $textRun->addText(' residente e domiciliado nesta Cidade em ' . $pessoa->logradouro . ', n?? ' . $pessoa->numero . ', ' . $pessoa->complemento . ' - ' . $pessoa->bairro . ', CEP: ' . $pessoa->cep . ', todos os valores relat??vos ao ', 'fBody');

            /*if($pessoa->count() > 1)
                $textRun->addText(' | ', 'fBodyItalic');*/
        }

        //$textRun = $section->addTextRun('pBody');
        $textRun->addText('contrato n?? ' . $contrato->numContrato . ' referente a ', 'fBodyItalic');
        $textRun->addText('(' . $contrato->objetoContrato . ')', 'fBodyCaps');
        $textRun->addText(' no qual dou ' , 'fBody');
        $textRun->addText('Plena Quita????o.', 'fBodyItalic');


        $section->addTextBreak(2);

        $textRun = $section->addTextRun('pRight');
        $textRun->addText('Manaus/AM, '. ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($contrato->dataVencContrato)))) . '.', 'fBodyItalicData' );

        $section->addTextBreak(1);

        $textRun = $section->addTextRun('pRight');
        $textRun->addText('Dra. Danielle Rufino A. Ricardo', 'fBody');

        $textRun = $section->addTextRun('pRight');
        $textRun->addText('OAB AM/RN 3643/1324-A', 'fBodyItalicData');

        $section->addTextBreak(1);

        $textRun = $section->addTextRun();
        $textRun->addLine($lineStyle);



        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('RECIBO_' .str_pad(($contrato->ReciboQuitacaoControlhe->id), 3, 0, STR_PAD_LEFT) . '_' . date('Y') . '.docx'));

        return response()->download(storage_path('RECIBO_' .str_pad(($contrato->ReciboQuitacaoControlhe->id), 3, 0, STR_PAD_LEFT) . '_' . date('Y') . '.docx'));

    }

    public function destroy($id)
    {
        return redirect()->back()->with('message', 'ContasReceber deleted.');
    }


}
