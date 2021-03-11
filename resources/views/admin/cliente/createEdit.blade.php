@extends('layouts.mastertop')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-12">
            <div class="col-sm-6">

                <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">

                    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li> -->
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    @if(isset($cliente))
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-user-circle"> </i> Alterar Cliente</h3>
                    </div>
                    {!! Form::model($cliente, ['route' => ['pessoa.update', $cliente->id], 'method' => 'put']) !!}
                    @else
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-user-circle"> </i> Cadastrar Cliente</h3>
                    </div>
                    {!! Form::open(['route' => 'pessoa.store', 'method' => 'post']) !!}
                    {!! Form::hidden('status', $value = 1) !!}
                    @endif

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" value=1 name="tipoPessoa"
                                        {{ isset($cliente->tipoPessoa) ? (($cliente->tipoPessoa == 1) ? "checked" : false) : "checked" }}
                                        id="fisica">
                                    <label for="fisica">
                                        Física
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" name="tipoPessoa" value=2 name="tipoPessoa"
                                        {{ isset($cliente->tipoPessoa) ? (($cliente->tipoPessoa == 2) ? "checked" : false) : true }}
                                        id="juridica">
                                    <label for="juridica">
                                        Jurídica
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">

                            <div class="form-group col-md-4">
                                <label id="nome"> Nome Cliente </label>
                                {!! Form::text('nomeRazaoSocial', $value = null, ['class' => 'form-control',
                                'onkeyup' => 'maiuscula(this)', 'autofocus', ]) !!}
                                {!! Form::hidden('id', $value = null) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>CPF / CNPJ</label>
                                {!! Form::text('cpfCnpj', $value = null, ['class' => 'form-control', 'id' => 'cpfCnpj'])
                                !!}
                            </div>

                            <div class="form-group col-md-2" id="nacionalidade">
                                <label>Nacionalidade</label>
                                {!! Form::text('nacionalidade', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2" id="estadoCivil">
                                <label>Estado Civil</label>
                                {!! Form::text('estadoCivil', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2" id="profissao">
                                <label>Profissão</label>
                                {!! Form::text('profissao', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2" id="rg">
                                <label>RG</label>
                                {!! Form::number('rg', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2" id="ctps">
                                <label>CTPS</label>
                                {!! Form::number('ctps', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-3">
                                <label>Email</label>
                                {!! Form::email('email', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2" id="dataNascimento">
                                <label>Data Nascimento</label>
                                {!! Form::date('dataNascimento', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2" id="orgExpedidor">
                                <label>Orgão Expedidor</label>
                                {!! Form::text('orgExpedidor', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-1" id="ufOrgExpedidor">
                                <label>UF</label>
                                {!! Form::text('ufOrgExpedidor', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-4">
                                <label>Logradouro</label>
                                {!! Form::text('logradouro', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-1">
                                <label>Numero</label>
                                {!! Form::number('numero', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-3">
                                <label>Complemento</label>
                                {!! Form::text('complemento', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Bairro</label>
                                {!! Form::text('bairro', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>CEP</label>
                                {!! Form::text('cep', $value = null, ['class' => 'form-control', 'data-inputmask' =>
                                '"mask": "99999-999"', 'data-mask']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Estado</label>
                                {!! Form::text('estado', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Cidade</label>
                                {!! Form::text('cidade', $value = null, ['class' => 'form-control'
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Telefone</label>
                                {!! Form::text('telefone', $value = null, ['class' => 'form-control', 'data-inputmask'
                                => '"mask": "(99) 9999-9999"', 'data-mask']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Celular 1</label>
                                {!! Form::text('celUm', $value = null, ['class' => 'form-control', 'data-inputmask' =>
                                '"mask": "(99) 99999-9999"', 'data-mask']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Celular 2</label>
                                {!! Form::text('celDois', $value = null, ['class' => 'form-control', 'data-inputmask' =>
                                '"mask": "(99) 99999-9999"', 'data-mask']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Celular 3</label>
                                {!! Form::text('celTres', $value = null, ['class' => 'form-control', 'data-inputmask' =>
                                '"mask": "(99) 99999-9999"', 'data-mask']) !!}
                            </div>
                        </div>

                        <div class="row" id="represetanteFisica" style="display:none">

                            <div class="form-group col-md-12">
                                <label> Possui Representante</label>
                            </div>

                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" name="r1" checked="">
                                    <label for="radioPrimary1">
                                        Não
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary2" name="r1">
                                    <label for="radioPrimary2">
                                        Sim
                                    </label>
                                </div>
                            </div>

                        </div>

                        <!-- ################# DADOS DO REPRESENTANTE DA EMPRESA ######################## -->
                        <div class="row" id="divpessoajuridica1" style="display:none">

                            <div class="form-group col-md-2">
                                <label>NIRE</label>
                                {!! Form::number('nire', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Insc Estadual</label>
                                {!! Form::number('inscEstadual', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Insc Municipal</label>
                                {!! Form::number('inscMunicipal', $value = null, ['class' => 'form-control']) !!}
                            </div>

                        </div>

                        <hr id="linha" style="display:none">

                        <div class="row" id="divpessoajuridica2" style="display:none">

                            <div class="form-group col-md-12">
                                <label> Dados do Representante</label>
                            </div>

                            <div class="form-group col-md-4">
                                <label> Nome Representante</label>
                                {!! Form::text('nomeRepresentante', $value = null, ['class' => 'form-control',
                                'onkeyup' => 'maiuscula(this)', 'autofocus', 'id' => 'nomeRepresentante' ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>CPF</label>
                                {!! Form::text('cpfRepresentante', $value = null, ['class' => 'form-control', 'id' =>
                                'cpfRepresentante']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Nacionalidade</label>
                                {!! Form::text('nacionalidadeRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Estado Civil</label>
                                {!! Form::text('estadoCivilRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Profissão</label>
                                {!! Form::text('profissaoRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>RG</label>
                                {!! Form::number('rgRepresentante', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>CTPS</label>
                                {!! Form::number('ctpsRepresentante', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-3">
                                <label>Email</label>
                                {!! Form::email('emailRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Data Nascimento</label>
                                {!! Form::date('dataNascimentoRepresentante', $value = null, ['class' =>
                                'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Orgão Expedidor</label>
                                {!! Form::text('orgExpedidorRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-1">
                                <label>UF</label>
                                {!! Form::text('ufOrgExpedidorRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-4">
                                <label>Logradouro</label>
                                {!! Form::text('logradouroRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-1">
                                <label>Numero</label>
                                {!! Form::number('numeroRepresentante', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-3">
                                <label>Complemento</label>
                                {!! Form::text('complementoRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Bairro</label>
                                {!! Form::text('bairroRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>CEP</label>
                                {!! Form::text('cepRepresentante', $value = null, ['class' => 'form-control',
                                'data-inputmask' => '"mask": "99999-999"', 'data-mask']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Estado</label>
                                {!! Form::text('estadoRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Cidade</label>
                                {!! Form::text('cidadeRepresentante', $value = null, ['class' => 'form-control',
                                ]) !!}
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::submit(isset($cliente) ? 'Alterar' : 'Salvar', ['class' => 'btn flat btn-primary'])
                        !!}
                        <a href="{{ route('pessoa.index') }}" class="btn flat btn-primary">Fechar</a>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.card -->

            </div>
        </div>
    </div>
    </div>


    @endsection

    @push('datatables-css')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bbootstrap -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endpush

    @push('datatables-script')

    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('adminlte/plugins/inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('adminlte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script src="{{ asset('js/funcoes.js') }}"></script>
    {!! Minify::javascript('/js/Pessoa.js') !!}

    @include('layouts.alerts.validationAlert')

    @endpush
