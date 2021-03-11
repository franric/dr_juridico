<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProcuracaoCreateRequest;
use App\Http\Requests\ProcuracaoUpdateRequest;
use App\Repositories\ProcuracaoRepository;
use App\Services\ProcuracaosServices;


class ProcuracaosController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(ProcuracaoRepository $repository, ProcuracaosServices $service)
    {
        $this->repository = $repository;
        $this->service  = $service;
    }

    public function index()
    {
        $procuracaos = $this->repository->all();
        foreach ($procuracaos as $proc) {
            $proc->Pessoa->cpfCnpj = \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($proc->Pessoa->cpfCnpj);
        }
        return view('admin.procuracao.index', compact('procuracaos'));
    }

    public function create()
    {
        return view('admin.procuracao.createEdit');
    }

    public function store(ProcuracaoCreateRequest $request)
    {
        $procuracao = $this->service->store($request->all());

        session()->flash('success', [
            'success' => $procuracao['success'],
            'messages' => $procuracao['messages']
        ]);

        return redirect()->route('procuracao.index');
    }

    public function edit($id)
    {
        $procuracao = $this->repository->find($id);

        return view('admin.procuracao.createEdit', compact('procuracao'));
    }

    public function destroy($id)
    {
        $procuracao = $this->service->destroy($id);

        session()->flash('success', [
            'success' => $procuracao['success'],
            'messages' => $procuracao['messages']
        ]);

        return response()->json($procuracao);
    }

    public function WordGenerate($id)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $procuracaos = $this->repository->find($id);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('pTituloCenter', array('alignment' => 'center'));
        $phpWord->addParagraphStyle('pPadrao', array('alignment' => 'both'));
        $phpWord->addParagraphStyle('pPadraoAssing', array('alignment' => 'right'));
        $phpWord->addFontStyle('fTituloCenter', array('name' => 'Calibri', 'size' => '12', 'bold' => true));
        $phpWord->addFontStyle('fPadrao', array('name' => 'Calibri', 'size' => '10'));
        $phpWord->addFontStyle('fPadraoBold', array('name' => 'Calibri', 'size' => '10', 'bold' => true));
        $phpWord->addFontStyle('fPadraoBoldItalico', array('name' => 'Calibri', 'size' => '10', 'bold' => true, 'italic' => true));
        $phpWord->addFontStyle('fPadraoBoldSubli', array('name' => 'Calibri', 'size' => '10', 'bold' => true, 'underline' => 'single'));

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
        $textrun->addText('Dra. Danielle Rufino Alves Ricardo – ', array('italic' => true ));
        $textrun->addText('OAB/AM 3643', array('italic' => true, 'size' => 8 ));
        $textrun = $cell->addTextRun(array('alignment' => 'right', 'valign' => 'bottom'));
        $textrun->addText('Dra. Stephanie Rufino Alves Betesek – ', array('italic' => true ));
        $textrun->addText('OAB/RN 18.326', array('italic' => true, 'size' => 8 ));
        $lineStyle = array('weight' => 2, 'width' => 450, 'height' => 2, 'color' => 'blue');
        $header->addLine($lineStyle);
        //$header->addWatermark('imagens/logo_dr.png', array('width' => 450, 'height' => 400));

        // Add footer
        $footer = $section->addFooter();
        $footer->addLine($lineStyle);
        $footer->addText('Rua Valência, nº 2, Q/64, Conj. Campos Eliseos – Planalto, CEP: 69045-560. MAO/AM.', array('italic' => true), array('align' => 'right'));
        $footer->addText('Email: am@drconsultoriajuridica.com | rn@drconsultoriajuridica.com', array('italic' => true), array('align' => 'right'));

        $section->addText(
            'P R O C U R A Ç Ã O  “A D J U D I C I A ET EXTRA”',
            'fTituloCenter',
            'pTituloCenter'
        );

        $section->addTextBreak(1);

        if($procuracaos->Pessoa->tipoPessoa == 1)
        {
            $textRun = $section->addTextRun('pPadrao');
            $textRun->addText('OUTORGANTE: ' . $procuracaos->Pessoa->nomeRazaoSocial, 'fPadraoBold');
            $textRun->addText(', '. $procuracaos->Pessoa->nacionalidade.', '. $procuracaos->Pessoa->estadoCivil .', '. $procuracaos->Pessoa->profissao .', portador do RG Nº ' . $procuracaos->Pessoa->rg .' ' . $procuracaos->Pessoa->orgExpedidor .'/' . $procuracaos->Pessoa->ufOrgExpedidor .', CPF Nº ' . \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfCnpj) . ', com endereço nesta Cidade na ' . $procuracaos->Pessoa->logradouro . ', Nº ' . $procuracaos->Pessoa->numero .', ' . $procuracaos->Pessoa->complemento . ', ' . $procuracaos->Pessoa->bairro . ', CEP: ' . preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $procuracaos->Pessoa->cep) .'; E-mail: drconsultoriajuridica.am@gmail.com.', 'fPadrao');
        } else {
            $textRun = $section->addTextRun('pPadrao');
            $textRun->addText('OUTORGANTE(S): ' . $procuracaos->Pessoa->nomeRazaoSocial, 'fPadraoBold');
            $textRun->addText(', devidamente inscrita sob o '
                . 'CNPJ ' .\App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfCnpj) . ' (Doc Digitalizado), registrada na Junta Comercial do Estado do Amazonas '
                . 'NIRE nº ' . $procuracaos->Pessoa->nire . ', estabelecida na ' . $procuracaos->Pessoa->logradouro . ', Nº ' . $procuracaos->Pessoa->numero . ', ' . (isset($procuracaos->Pessoa->complemento) ? $procuracaos->Pessoa->complemento . " - " : "") . ' ' . $procuracaos->Pessoa->bairro . ', CEP: ' . preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $procuracaos->Pessoa->cep) . ' neste ato '
                . 'representado pelo Sr. ');
            $textRun->addText($procuracaos->Pessoa->nomeRepresentante, 'fPadraoBold');
            $textRun->addText(', ' . $procuracaos->Pessoa->nacionalidadeRepresentante . ', ' . $procuracaos->Pessoa->profissaoRepresentante . ', portador do RG '
                . 'Nº ' . $procuracaos->Pessoa->rgRepresentante . ' ' . $procuracaos->Pessoa->orgExpedidorRepresentante . '/' . $procuracaos->Pessoa->ufOrgExpedidorRepresentante . ', CPF Nº ' . \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfRepresentante) . 'com endereço nesta Cidade na '
                . $procuracaos->Pessoa->logradouroRepresentante . ', Nº ' . $procuracaos->Pessoa->numeroRepresentante . ', ' . (isset($procuracaos->Pessoa->complementoRepresentante) ? $procuracaos->Pessoa->complementoRepresentante . " - " : "") . ' ' . $procuracaos->Pessoa->bairroRepresentante . ', CEP: ' .  preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $procuracaos->Pessoa->cepRepresentante) . '; e-mail: proc_ct@drconsultoriajuridica.com');
        }

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Pelo presente instrumento, nomeia e constitui suas bastantes procuradoras, as advogadas', 'fTituloCenter');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('OUTORGADAS: Dra. DANIELLE RUFINO ALVES RICARDO', 'fPadraoBold');
        $textRun->addText(', brasileira, casada, Advogada, inscrita regularmente na Ordem dos Advogados do Brasil, Seção/AM sob o n.º 3.643, Seção/RN sob o n.º 1324-A, ', 'fPadrao');
        $textRun->addText('Dra. STEPHANIE RUFINO ALVES BETESEK', 'fPadraoBold');
        $textRun->addText(', brasileira, solteira, Advogada, inscrita regularmente na Ordem dos Advogados do Brasil, Seção/RN sob o n.º 18.326, ambas com escritório profissional na Cidade de Manaus/AM  à Rua Valência, nº 02, Q/64, Conj. Campos Eliseos - Planalto, CEP: 69045-560. E-mail: am@drconsultoriajuridica.com; rn@drconsultoriajuridica.com; cel (92) 98475-8975 | (84) 99955-4495', 'fPadrao');

        $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('PODERES: ', 'fPadraoBold');
        $textRun->addText('Por este instrumento particular de procuração, constituo meu procurador o outorgado, concedendo-lhe os poderes especiais para tudo que se fizer necessário para minha defesa, incluindo a cláusula ad judicia, para o foro em geral, salvo receber citação inicial, como assim proclama o art. 105 do Novo CPC.', 'fPadrao');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('PODERES ESPECÍFICOS: ', 'fPadraoBold');
        $textRun->addText('A presente procuração outorga as Advogadas acima descritas, os poderes para pedir à justiça gratuita e assinar declaração de hipossuficiência economica, conforme o diposto no art. 105 do Novo CPC; representar-me nas audiências, requerer, transigir, confessar, renunciar, assinar, desistir, firmar compromissos é/ou acordos, receber e dar quitações, efetuar levantamentos de avará, falar em nome do Outorgante, agindo em conjunto ou separadamente, dando tudo por bom, firme e valioso, para me reresentar em juízo.', 'fPadrao');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('FINALIDADE: ', 'fPadraoBold');
        $textRun->addText('representá-lo no Fórum em Geral com a Cláusula “AD JUDICIA ET EXTRA”, em qualquer causa ou ação, que seja ou ré(u) assistente(s) ou oponente(s) ou por qualquer modo interessado(s),  a fim de agir em qualquer Juízo, Instância ou Tribunal, ou ainda nas Repartições Federais, Estaduais e Municipais, Cartórios Tabelionato de Notas, Cartório de Registro de Títulos e Documentos (RTD) Cartório de Registro de Imóveis (RI) Tabelionatos de Protesto, Cartório de Registro Civil de Pessoas Jurídicas, inclusive JUNTA COMERCIAL do Estado do Amazonas, podendo para isso requerer e promover judicial ou extrajudicialmente, propor ação ou ações, produzir provas e seguir qualquer recurso legal; representar ao Conselho Superior de Magistratura, ao Corregedor Geral da Justiça, alegar e defender todo o seu Direito de Justiça, acordar, desistir, recorrer, apelar, transigir, discordar, dar de suspeito a quem lhe convier, dar e receber quitação, passar recibo(s), enfim, tratar de seus interesses, bem como praticar todos os atos, para o fiel cumprimento do presente mandato, inclusive, substabelecer.', 'fPadrao');

        $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText('Manaus/AM, '. ucfirst(utf8_encode(strftime('%d de %B de %Y', strtotime($procuracaos->created_at)))) . '.');

       // $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText('____________________________________________________');
        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText($procuracaos->Pessoa->nomeRazaoSocial, 'fPadraoBold');
        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText('CPF Nº ' . \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfCnpj), 'fPadraoBold');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('PROCURAÇÃO_' . $procuracaos->Pessoa->nomeRazaoSocial . '_' . $procuracaos->Pessoa->cpfCnpj . '.docx'));

        return response()->download(storage_path('PROCURAÇÃO_' . $procuracaos->Pessoa->nomeRazaoSocial . '_' . $procuracaos->Pessoa->cpfCnpj . '.docx'));

    }
}
