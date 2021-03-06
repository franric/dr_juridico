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
        $textrun->addText('Dra. Danielle Rufino Alves Ricardo ??? ', array('italic' => true ));
        $textrun->addText('OAB/AM 3643', array('italic' => true, 'size' => 8 ));
        $textrun = $cell->addTextRun(array('alignment' => 'right', 'valign' => 'bottom'));
        $textrun->addText('Dra. Stephanie Rufino Alves Betesek ??? ', array('italic' => true ));
        $textrun->addText('OAB/RN 18.326', array('italic' => true, 'size' => 8 ));
        $lineStyle = array('weight' => 2, 'width' => 450, 'height' => 2, 'color' => 'blue');
        $header->addLine($lineStyle);
        //$header->addWatermark('imagens/logo_dr.png', array('width' => 450, 'height' => 400));

        // Add footer
        $footer = $section->addFooter();
        $footer->addLine($lineStyle);
        $footer->addText('Rua Val??ncia, n?? 2, Q/64, Conj. Campos Eliseos ??? Planalto, CEP: 69045-560. MAO/AM.', array('italic' => true), array('align' => 'right'));
        $footer->addText('Email: am@drconsultoriajuridica.com | rn@drconsultoriajuridica.com', array('italic' => true), array('align' => 'right'));

        $section->addText(
            'P R O C U R A ?? ?? O  ???A D J U D I C I A ET EXTRA???',
            'fTituloCenter',
            'pTituloCenter'
        );

        $section->addTextBreak(1);

        if($procuracaos->Pessoa->tipoPessoa == 1)
        {
            $textRun = $section->addTextRun('pPadrao');
            $textRun->addText('OUTORGANTE: ' . $procuracaos->Pessoa->nomeRazaoSocial, 'fPadraoBold');
            $textRun->addText(', '. $procuracaos->Pessoa->nacionalidade.', '. $procuracaos->Pessoa->estadoCivil .', '. $procuracaos->Pessoa->profissao .', portador do RG N?? ' . $procuracaos->Pessoa->rg .' ' . $procuracaos->Pessoa->orgExpedidor .'/' . $procuracaos->Pessoa->ufOrgExpedidor .', CPF N?? ' . \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfCnpj) . ', com endere??o nesta Cidade na ' . $procuracaos->Pessoa->logradouro . ', N?? ' . $procuracaos->Pessoa->numero .', ' . $procuracaos->Pessoa->complemento . ', ' . $procuracaos->Pessoa->bairro . ', CEP: ' . preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $procuracaos->Pessoa->cep) .'; E-mail: drconsultoriajuridica.am@gmail.com.', 'fPadrao');
        } else {
            $textRun = $section->addTextRun('pPadrao');
            $textRun->addText('OUTORGANTE(S): ' . $procuracaos->Pessoa->nomeRazaoSocial, 'fPadraoBold');
            $textRun->addText(', devidamente inscrita sob o '
                . 'CNPJ ' .\App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfCnpj) . ' (Doc Digitalizado), registrada na Junta Comercial do Estado do Amazonas '
                . 'NIRE n?? ' . $procuracaos->Pessoa->nire . ', estabelecida na ' . $procuracaos->Pessoa->logradouro . ', N?? ' . $procuracaos->Pessoa->numero . ', ' . (isset($procuracaos->Pessoa->complemento) ? $procuracaos->Pessoa->complemento . " - " : "") . ' ' . $procuracaos->Pessoa->bairro . ', CEP: ' . preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $procuracaos->Pessoa->cep) . ' neste ato '
                . 'representado pelo Sr. ');
            $textRun->addText($procuracaos->Pessoa->nomeRepresentante, 'fPadraoBold');
            $textRun->addText(', ' . $procuracaos->Pessoa->nacionalidadeRepresentante . ', ' . $procuracaos->Pessoa->profissaoRepresentante . ', portador do RG '
                . 'N?? ' . $procuracaos->Pessoa->rgRepresentante . ' ' . $procuracaos->Pessoa->orgExpedidorRepresentante . '/' . $procuracaos->Pessoa->ufOrgExpedidorRepresentante . ', CPF N?? ' . \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfRepresentante) . 'com endere??o nesta Cidade na '
                . $procuracaos->Pessoa->logradouroRepresentante . ', N?? ' . $procuracaos->Pessoa->numeroRepresentante . ', ' . (isset($procuracaos->Pessoa->complementoRepresentante) ? $procuracaos->Pessoa->complementoRepresentante . " - " : "") . ' ' . $procuracaos->Pessoa->bairroRepresentante . ', CEP: ' .  preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $procuracaos->Pessoa->cepRepresentante) . '; e-mail: proc_ct@drconsultoriajuridica.com');
        }

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('Pelo presente instrumento, nomeia e constitui suas bastantes procuradoras, as advogadas', 'fTituloCenter');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('OUTORGADAS: Dra. DANIELLE RUFINO ALVES RICARDO', 'fPadraoBold');
        $textRun->addText(', brasileira, casada, Advogada, inscrita regularmente na Ordem dos Advogados do Brasil, Se????o/AM sob o n.?? 3.643, Se????o/RN sob o n.?? 1324-A, ', 'fPadrao');
        $textRun->addText('Dra. STEPHANIE RUFINO ALVES BETESEK', 'fPadraoBold');
        $textRun->addText(', brasileira, solteira, Advogada, inscrita regularmente na Ordem dos Advogados do Brasil, Se????o/RN sob o n.?? 18.326, ambas com escrit??rio profissional na Cidade de Manaus/AM  ?? Rua Val??ncia, n?? 02, Q/64, Conj. Campos Eliseos - Planalto, CEP: 69045-560. E-mail: am@drconsultoriajuridica.com; rn@drconsultoriajuridica.com; cel (92) 98475-8975 | (84) 99955-4495', 'fPadrao');

        $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('PODERES: ', 'fPadraoBold');
        $textRun->addText('Por este instrumento particular de procura????o, constituo meu procurador o outorgado, concedendo-lhe os poderes especiais para tudo que se fizer necess??rio para minha defesa, incluindo a cl??usula ad judicia, para o foro em geral, salvo receber cita????o inicial, como assim proclama o art. 105 do Novo CPC.', 'fPadrao');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('PODERES ESPEC??FICOS: ', 'fPadraoBold');
        $textRun->addText('A presente procura????o outorga as Advogadas acima descritas, os poderes para pedir ?? justi??a gratuita e assinar declara????o de hipossufici??ncia economica, conforme o diposto no art. 105 do Novo CPC; representar-me nas audi??ncias, requerer, transigir, confessar, renunciar, assinar, desistir, firmar compromissos ??/ou acordos, receber e dar quita????es, efetuar levantamentos de avar??, falar em nome do Outorgante, agindo em conjunto ou separadamente, dando tudo por bom, firme e valioso, para me reresentar em ju??zo.', 'fPadrao');

        $textRun = $section->addTextRun('pPadrao');
        $textRun->addText('FINALIDADE: ', 'fPadraoBold');
        $textRun->addText('represent??-lo no F??rum em Geral com a Cl??usula ???AD JUDICIA ET EXTRA???, em qualquer causa ou a????o, que seja ou r??(u) assistente(s) ou oponente(s) ou por qualquer modo interessado(s),  a fim de agir em qualquer Ju??zo, Inst??ncia ou Tribunal, ou ainda nas Reparti????es Federais, Estaduais e Municipais, Cart??rios Tabelionato de Notas, Cart??rio de Registro de T??tulos e Documentos (RTD) Cart??rio de Registro de Im??veis (RI) Tabelionatos de Protesto, Cart??rio de Registro Civil de Pessoas Jur??dicas, inclusive JUNTA COMERCIAL do Estado do Amazonas, podendo para isso requerer e promover judicial ou extrajudicialmente, propor a????o ou a????es, produzir provas e seguir qualquer recurso legal; representar ao Conselho Superior de Magistratura, ao Corregedor Geral da Justi??a, alegar e defender todo o seu Direito de Justi??a, acordar, desistir, recorrer, apelar, transigir, discordar, dar de suspeito a quem lhe convier, dar e receber quita????o, passar recibo(s), enfim, tratar de seus interesses, bem como praticar todos os atos, para o fiel cumprimento do presente mandato, inclusive, substabelecer.', 'fPadrao');

        $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText('Manaus/AM, '. ucfirst(utf8_encode(strftime('%d de %B de %Y', strtotime($procuracaos->created_at)))) . '.');

       // $section -> addTextBreak(1);

        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText('____________________________________________________');
        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText($procuracaos->Pessoa->nomeRazaoSocial, 'fPadraoBold');
        $textRun = $section->addTextRun('pPadraoAssing');
        $textRun->addText('CPF N?? ' . \App\Funcoes\ConvertNumeroTexto::formatCnpjCpf($procuracaos->Pessoa->cpfCnpj), 'fPadraoBold');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('PROCURA????O_' . $procuracaos->Pessoa->nomeRazaoSocial . '_' . $procuracaos->Pessoa->cpfCnpj . '.docx'));

        return response()->download(storage_path('PROCURA????O_' . $procuracaos->Pessoa->nomeRazaoSocial . '_' . $procuracaos->Pessoa->cpfCnpj . '.docx'));

    }
}
