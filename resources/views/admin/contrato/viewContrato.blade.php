@extends('layouts.mastertop')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <!-- <div class="box-header with-border">
                            <a class="btn btn-danger btn-flat pull-right" target="_blank" href="{{ url('contrato/PdfGenerete', $contratos->id) }}">
                                <i class="fa fa-file-pdf"></i> Gerar PDF</a>

                        </div> -->

                        <div class="box-header with-border" style="margin-left: 1rem">
                            <a class="btn btn-info btn-flat pull-right" target="_blank" href="{{ url('contrato/WordGenerate', $contratos->id) }}">
                                <i class="fa fa-file-word"></i> Gerar Word</a>

                        </div>

                        <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li> -->
                    </ol>
                </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3  class="card-title" ><i class="fa fa-balance-scale"></i> Contrato de Honorários</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    @if(isset($contratos))
                        <div class="px-4 py-2">
                                <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img src="{{ asset('imagens/logo_dr.png') }}"  width="80px" height="80px"/>
                                            </div>
                                            <div class="col-md-5" style="margin-top: 4%">
                                                <h3 class="text-left">
                                                    CONSULTORIA JURÍDICA
                                                </h3>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="text-right">
                                                    <em>Dra. Danielle Rufino Alves Ricardo – OAB/AM 3643</em>
                                                </h5>
                                                <h5 class="text-right">
                                                    <em>OAB/RN 1324-A</em>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                <hr style="width: 100%; color: blue; height: 1px; background-color:blue;">

                            <div class="content-header">
                                <h1 class="text-dark text-center ">CONTRATO HONORÁRIOS ADVOCATÍCIOS Nº DRHN_{{ $contratos->numContrato }}</h1>
                                <br>
                            </div>

                            <div class="content px-2">
                                <hr>
                                <p class="text-center">
                                    <u>
                                            <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
                                        <br>
                                    </u>
                                </p>

                                @foreach ($contratos->Pessoa as $pessoa)

                                    @if($pessoa->tipoPessoa == 1)
                                        <p class="text-justify"> <strong> CONTRATANTE: {{ $pessoa->nomeRazaoSocial }} </strong>, {{ $pessoa->nacionalidade }}, {{ $pessoa->profissao }}, {{ $pessoa->estadoCivil }}, portador do RG
                                           Nº {{ $pessoa->rg }} {{ $pessoa->orgExpedidor }}/{{ $pessoa->ufOrgExpedidor }}, CPF Nº {{ $pessoa->cpfCnpj }} com endereço nesta Cidade na {{ $pessoa->logradouro }},
                                           Nº {{ $pessoa->numero }}, {{ isset($pessoa->complemento) ? $pessoa->complemento . " - " : "" }} {{ $pessoa->bairro }}, CEP: {{ $pessoa->cep }} e-mail: {{ $pessoa->email }};</p>
                                    @else
                                        <p class="text-justify"> <strong> CONTRATANTE: {{ $pessoa->nomeRazaoSocial }} </strong>, devidamente inscrita sob o
                                            CNPJ {{ $pessoa->cpfCnpj }} (Doc Digitalizado), registrada na Junta Comercial do Estado do Amazonas
                                            NIRE nº {{ $pessoa->nire }}, bem como alteração contratual sob registro nº 471574 perante este mesmo
                                            órgão, estabelecida na {{ $pessoa->logradouro }}, Nº {{ $pessoa->numero }}, {{ isset($pessoa->complemento) ? $pessoa->complemento . " - " : "" }} {{ $pessoa->bairro }}, CEP: {{ $pessoa->cep }} neste ato
                                            representado pelo Sr. <strong>{{ $pessoa->nomeRepresentante }}</strong>, {{ $pessoa->nacionalidadeRepresentante }}, {{ $pessoa->profissaoRepresentante }}, portador do RG
                                            Nº {{ $pessoa->rgRepresentante }} {{ $pessoa->orgExpedidorRepresentante }}/{{ $pessoa->ufOrgExpedidorRepresentante }}, CPF Nº {{ $pessoa->cpfRepresentante }} com endereço nesta Cidade na
                                            {{ $pessoa->logradouroRepresentante }}, Nº {{ $pessoa->numeroRepresentante }}, {{ isset($pessoa->complementoRepresentante) ? $pessoa->complementoRepresentante . " - " : "" }} {{ $pessoa->bairroRepresentante }}, CEP: {{ $pessoa->cepRepresentante }} e-mail: {{ $pessoa->emailRepresentante }};</p>
                                    @endif

                                @endforeach
                                <br>
                                <p class="text-justify">
                                    <strong>CONTRATADA: Dra. DANIELLE RUFINO ALVES RICARDO</strong>, brasileira, casada, Advogada, inscrita
                                    regularmente na Ordem dos Advogados do Brasil, Seção/AM sob o n.º 3.643, Seção/RN sob o número n.º
                                    1324-A com escritório profissional na Cidade de Manaus/AM à Rua Valência, nº 02, Q/64, Conj. Campos
                                    Eliseos - Planalto, CEP: 69045-560. E-mail: atendimento@drconsultoriajurídica.com; cel(92)98475-8975
                                </p>
                                <hr>

                                <br>

                                <p class="text-justify"><strong><em>As partes acima identificadas têm, entre si, justo e acertado o presente Contrato de Honorários
                                        Advocatícios, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.</em></strong></p>
                                <br>

                                <h5 class="text-bold text-dark"><u>DO OBJETO DO CONTRATO</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 1ª.</strong> O presente instrumento tem como OBJETO a prestação de serviços advocatícios referentes
                                    a <strong>{{ $contratos->objetoContrato }}.</strong>
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DAS ATIVIDADES</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 2ª.</strong> As atividades inclusas na prestação de serviço objeto deste instrumento são todas aquelas
                                    inerentes à profissão, quais sejam:
                                </p>
                                <p class="text-justify">
                                    &emsp;&emsp;<strong>a)</strong> Praticar quaisquer atos e medidas necessárias e inerentes à causa, em todas as repartições
                                    públicas da União, dos Estados ou dos Municípios, bem como órgãos a estes ligados direta ou
                                    indiretamente, seja por delegação, concessão ou outros meios, bem como de estabelecimentos
                                    particulares.
                                </p>
                                <p class="text-justify">
                                    &emsp;&emsp;<strong>b)</strong> Praticar todos os atos inerentes ao exercício da advocacia e aqueles constantes no Estatuto da
                                    Ordem dos Advogados do Brasil, bem como os especificados no Instrumento Procuratório.
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DOS ATOS PROCESSUAIS</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 3ª.</strong> Havendo necessidade de contratação de outros profissionais, no decurso do processo, a
                                    <strong>CONTRATADA</strong> elaborará substabelecimento, indicando escritório de seu conhecimento, restando
                                    facultado ao <strong>CONTRATANTE</strong> aceitá-lo ou não. Aceitando, ficará sob a responsabilidade, única e
                                    exclusivamente do <strong>CONTRATANTE</strong> no que concerne aos honorários e atividades a serem exercidas.
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DAS DESPESAS</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 4ª.</strong> Todas as despesas efetuadas pela <strong>CONTRATADA</strong>, ligadas direta ou indiretamente com o
                                    processo, incluindo-se fotocópias, emolumentos, viagens, custas, entre outros, ficarão a cargo do
                                    <strong>CONTRATANTE</strong>.
                                </p>
                                <p class="text-justify">
                                    <strong>Cláusula 5ª.</strong> Todas as despesas serão acompanhadas de recibo, devidamente preparado e assinado
                                    pela <strong>CONTRATADA</strong>.
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DA COBRANÇA</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 6ª.</strong> As partes acordam que facultará a <strong>CONTRATADA</strong>, o direito de realizar a cobrança dos
                                    honorários por todos os meios admitidos em direito.
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DOS HONORÁRIOS</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 7ª.</strong> Fica acordado entre as partes que os honorários a título de prestação de serviços jurídicos
                                    objeto da Cláusula 1ª do presente instrumento contratual, conforme orçamento enviado por
                                    correspondência eletrônica nesta data,

                                    @if(isset($contratos->numParcelaContrato) && $contratos->numParcelaContrato == 0 )
                                        o <strong>CONTRATANTE</strong> deverá pagar o valor de <strong>R$ {{ number_format($contratos->valorContrato, 2, ',', '.') }}
                                        ( {{ $contratos->valorExteContrato }} )</strong> na data de <strong>{{ date('d/m/Y', strtotime($contratos->dataVencContrato)) }}</strong>
                                        devendo ser realizado em uma das seguintes modalidades, depósito em dinheiro ou TED em Instituição Financeira
                                        <strong>BANCO ITAÚ, AGÊNCIA 7163, CONTA 31843-4</strong>, ou em espécie, cartão de crédito ou débito em conta no escritório da <strong>CONTRATADA</strong>.
                                    @endif

                                    @if(isset($contratos->numParcelaContrato) && $contratos->numParcelaContrato > 0 && $contratos->valorEntradaContrato > 0)
                                        o <strong>CONTRATANTE</strong> deverá pagar o valor de <strong>R$ {{ number_format($contratos->valorContrato, 2, ',', '.') }}
                                        ( {{ $contratos->valorExteContrato }} )</strong> sendo no ato da assinatura do contrato uma entrada no valor de <strong>R$ {{ number_format($contratos->valorEntradaContrato, 2, ',', '.') }}
                                        ( {{ $contratos->valorExteEntContrato }} )</strong> e o restante parcelado em <strong>{{ $contratos->numParcelaContrato }} ( {{ $contratos->numParcelaExtenso }} )</strong>
                                        parcela(s) iguais, no valor de <strong>R$ {{ number_format($contratos->valorParcelaContrato, 2, ',', '.') }} ( {{ $contratos->valorParcelaContratoExtenso }} )</strong> sendo o primeiro vencimento para o dia <strong>{{ date('d/m/Y', strtotime($contratos->dataVencContrato)) }}</strong>
                                        @if($contratos->numParcelaContrato > 1)
                                            e as demais a cada 30 dias após a parcela vencida,
                                        @endif
                                        devendo ser realizado em uma das seguintes modalidades, depósito em dinheiro ou TED em Instituição Financeira
                                        <strong>BANCO CAIXA ECONOMICA FEDERAL, AGÊNCIA 2897, CONTA 796828921-2 OP1288</strong>, ou em espécie, cartão de crédito ou débito no escritório da <strong>CONTRATADA</strong>, 
                                        podendo ainda ser custeado na modalidade descrita no <strong>§1º</strong>.
                                    @endif

                                    @if(isset($contratos->numParcelaContrato) && $contratos->numParcelaContrato > 0 && $contratos->valorEntradaContrato == 0)
                                        o <strong>CONTRATANTE</strong> deverá pagar o valor de <strong>R$ {{ number_format($contratos->valorContrato, 2, ',', '.') }}
                                        ( {{ $contratos->valorExteContrato }} )</strong> parcelado em <strong>{{ $contratos->numParcelaContrato }} ( {{ $contratos->numParcelaExtenso }} )</strong>
                                        parcela(s) iguais, no valor de <strong>R$ {{ number_format($contratos->valorParcelaContrato, 2, ',', '.') }} ( {{ $contratos->valorParcelaContratoExtenso }} )</strong> sendo o primeiro vencimento para o dia <strong>{{ date('d/m/Y', strtotime($contratos->dataVencContrato)) }}</strong>
                                        @if($contratos->numParcelaContrato > 1)
                                            e as demais a cada 30 dias após a parcela vencida,
                                        @endif
                                        devendo ser realizado em uma das seguintes modalidades, depósito em dinheiro ou TED em Instituição Financeira
                                        <strong>BANCO CAIXA ECONOMICA FEDERAL, AGÊNCIA 2897, CONTA 796828921-2 OP1288</strong>, ou em espécie, cartão de crédito ou débito no escritório da <strong>CONTRATADA</strong>, 
                                        podendo ainda ser custeado na modalidade descrita no <strong>§1º</strong>.
                                    @endif
                                </p>
                                <p>
                                    &emsp;&emsp;&emsp;<strong>§1º. PIX: CHAVE: E-MAIL: DRCONSULTORIAJURIDICA.AM@GMAIL.COM</strong>
                                </p>
                                <p>
                                    &emsp;&emsp;&emsp;<strong>§2º. EM CASO DE NÃO PAGAMENTO DA PARCELA ATÉ A DATA DO VENCIMENTO, O CONTRATANTE
                                    PAGARÁ O VALOR DA PARCELA EM DOBRO, COMO INDENIZAÇÃO POR PERDAS E DANOS.</strong>
                                </p>
                                <p>
                                    &emsp;&emsp;&emsp;<strong>§3º. CASO AS DATAS ACIMA ESTIPULADAS PARA PAGAMENTO NA CLÁUSULA 7ª,
                                    ocorram em finais de semana (sábado/domingo) e/ou em feriados(nacionais/estaduais/municipais)
                                    o CONTRATANTE</strong> obriga-se a custear o valor supra na data exata discriminada, devido as inúmeras
                                    possibilidades de pagamento, descritos no caput desta.
                                </p>
                                
                                <p class="text-justify">
                                    <strong>Cláusula 8ª.</strong> Deixando motivadamente, de ter o patrocínio deste causídico, ora contratado, o valor
                                    prestado inicialmente na propositura da Ação reverter-se-á em favor do mesmo, sem prejuízos de
                                    posteriores cobranças judiciais, em face do <strong>CONTRATANTE</strong>.
                                </p>
                                <p class="text-justify">
                                    <strong>Cláusula 9ª.</strong> Os honorários de sucumbência pertencem ao <strong>CONTRATADO</strong>, se estes houverem.
                                </p>
                                <p class="text-justify">
                                    <strong>Parágrafo único</strong>. Caso haja morte ou incapacidade civil da <strong>CONTRATADA</strong>, seus herdeiros e sucessores
                                    ou representante legal receberão os honorários na proporção do trabalho realizado.
                                </p>
                                <p class="text-justify">
                                    <strong>Cláusula 10ª.</strong> Havendo acordo entre o <strong>CONTRATANTE</strong> e a parte contrária, não prejudicará o
                                    recebimento dos honorários contratados e honorários sucumbenciais, caso em que os horários iniciais e
                                    finais serão pagos a <strong>CONTRATADA</strong>.
                                </p>
                                <p class="text-justify">
                                    <strong>Cláusula 11ª.</strong>As partes estabelecem que havendo atraso no pagamento sejam cobrados, PERDAS E
                                    DANOS em conformidade com os §1º e §2º, Cláusula 7ª item “DOS HONORÁRIOS”, e ainda cobrados,
                                     multa de 15% (quinze por cento) e juros de mora na proporção de 1% (um por cento) ao mês, conforme art. 412 do Código Civil Brasileiro.
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DA RESCISÃO</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 12ª</strong>. Agindo o <strong>CONTRATANTE</strong> de forma dolosa ou culposa em face da <strong>CONTRATADA</strong>, restará
                                    facultado a este, rescindir o contrato, substabelecendo sem reserva de iguais e se exonerando de todas
                                    as obrigações.
                                </p>

                                <br>

                                <h5 class="text-bold text-dark"><u>DO FORO</u></h5>
                                <p class="text-justify">
                                    <strong>Cláusula 13ª</strong>. Para dirimir quaisquer controvérsias oriundas do <strong>CONTRATO</strong>, as partes elegem o foro da
                                    Comarca de {{ $contratos->comarcaCidadeContrato }} no estado do {{ $contratos->comarcaEstadoContrato }}.
                                </p>
                                <p class="text-justify">
                                    Por estarem assim justos e contratados, firmam o presente instrumento, em duas vias de igual teor,
                                    dispensa testemunhas e assinaturas físicas, modalidade contratual virtual, com certificação de veracidade por ID e-mail Contratante e Contratado.

                                </p>
                            </div>
                            <br>
                            <hr style="width: 100%; color: blue; height: 1px; background-color:blue;">
                            <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-right">
                                                <em>Rua Valência, nº 2, Q/64, Conj. Campos Eliseos – Planalto, CEP: 69045-560. MAO/AM</em>
                                            </h5>
                                            <h5 class="text-right">
                                                <em>Email: danielle.adv@hotmail.com</em>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>

<div class="modal fade" data-backdrop="static" id="modal-default">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Gerando Aguarde ...</h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div id="loaderImage"></div>
                        <div class="col-md-4"></div>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@push('datatables-css')

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/docs.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/highlighter.css') }}">
@endpush

@push('datatables-script')
<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('preloader/loader.js') }}"></script>

@endpush
