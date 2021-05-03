@extends('layouts.mastertop')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-12">
            <div class="col-sm-6">
                @include('layouts.alerts.validationAlert')
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

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Incluir Cliente ao Contrato</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group clearfix">
                                                <div class="icheck-info d-inline">
                                                    <input type="radio" value=1 name="tipoPessoa" checked id="fisica">
                                                    <label for="fisica">
                                                        Física
                                                    </label>
                                                </div>
                                                <div class="icheck-info d-inline">
                                                    <input type="radio" name="tipoPessoa" value=2 name="tipoPessoa"
                                                        id="juridica">
                                                    <label for="juridica">
                                                        Jurídica
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                {!! Form::text('cpfCnpj', $value = null, ['class' => 'form-control',
                                                'id' =>
                                                'cpfCnpj',
                                                'Placeholder' => 'CPF']) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="button" onclick="getPessoaContrato()" value="Buscar"
                                                    class="btn flat btn-info">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0" style="height: 140px;">
                                                        <table id="tabelaClientes" class="table table-head-fixed">
                                                            <thead>
                                                                <tr>
                                                                    <th>Cliente</th>
                                                                    <th>CPF / CNPJ</th>
                                                                    <th>Remover</th>
                                                                    <th style="display: none">id</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="pessoasDados">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <!-- /.card -->
                                            </div>


                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                            </div>

                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Incluir Receitas ao Contrato</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Tipo Despesa</label>
                                                <select class="form-control select2" id="receitaSelect"
                                                    style="width: 100%;">

                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>Valor</label>
                                                {!! Form::number('valorContrato', $value = null, ['class' =>
                                                'form-control',
                                                'id' => 'valorContrato']) !!}
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="text-white">.</label>
                                                <input type="button" onclick="addReceita()" value="Add"
                                                    class="btn flat btn-info col-md-12">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">

                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0" style="height: 145px;">
                                                        <table id="tabelaReceitas" class="table table-head-fixed">
                                                            <thead>
                                                                <tr>
                                                                    <th>Receita</th>
                                                                    <th>Valor</th>
                                                                    <th>Remover</th>
                                                                    <th style="display:none">receita_id</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="receitasDados">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <!-- /.card -->
                                            </div>


                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!-- /.col (right) -->
                        </div>

                    </div>

                    <!-- form start -->

                    @if(isset($contrato))
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-balance-scale"> </i> Alterar Contrato Gerado</h3>
                    </div>
                    {!! Form::model($contrato, ['route' => ['contrato.update', $contrato->id], 'method' => 'put']) !!}
                    @else
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-balance-scale"> </i> Gerar Contrato</h3>
                    </div>
                    {!! Form::open(['id' => 'frmContrato']) !!}
                    {!! Form::hidden('statusContrato', $value = 1) !!}
                    @endif

                    <div class="card-body">

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label>Objeto do Contrato</label>
                                {!! Form::textarea('objetoContrato', $value = null, ['rows' => '3', 'class' =>
                                'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Valor</label>
                                {!! Form::number('valorContrato', $value = null, ['class' => 'form-control', 'id' =>
                                'valorTotalContrato', 'readonly']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Valor Entrada</label>
                                {!! Form::number('valorEntradaContrato', $value = null, ['class' => 'form-control', 'id'
                                => 'valorEntradaContrato',]) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Data Vencimento Entrada</label>
                                {!! Form::date('dataVencEntrada', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Comarca Cidade</label>
                                {!! Form::text('comarcaCidadeContrato', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Comarca Estado</label>
                                {!! Form::text('comarcaEstadoContrato', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Num Parcelas</label>
                                {!! Form::number('numParcelaContrato', $value = null, ['class' => 'form-control', 'id'
                                => 'numParcelas']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label>Data Vencimento</label>
                                {!! Form::date('dataVencContrato', $value = null, ['class' => 'form-control']) !!}
                                {!! Form::hidden('cliente[]', $value = null, ['id' => 'cliente', 'class' =>
                                'form-control']) !!}
                                {!! Form::hidden('receita[]', $value = null, ['id' => 'receita', 'class' =>
                                'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">

                        {!! Form::button(isset($contrato) ? 'Alterar' : 'Salvar', ['class' => 'btn flat btn-primary',
                        'id' => 'btnSalvarr', 'onclick' => 'btnSalvar()']) !!}

                        <a href="{{ route('contrato.index') }}" class="btn flat btn-primary">Fechar</a>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.card -->

            </div>
        </div>
</section>

<div class="modal fade"  id="modal-default">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitulo">Gerando Contrato ...</h5>

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
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<!-- Tempusdominus Bbootstrap -->
<link rel="stylesheet"
    href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('datatables-script')

<!-- Select2 -->
{!! Minify::javascript('/adminlte/plugins/select2/js/select2.full.min.js') !!}
<!-- InputMask -->
{!! Minify::javascript('/adminlte/plugins/inputmask/jquery.inputmask.bundle.js') !!}
{!! Minify::javascript('/adminlte/plugins/moment/moment.min.js') !!}
<!-- bootstrap color picker -->
{!! Minify::javascript('/adminlte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') !!}
<!-- Tempusdominus Bootstrap 4 -->
{!! Minify::javascript('/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}
{!! Minify::javascript('/js/funcoes.js') !!}
{!! Minify::javascript('/preloader/loader.js') !!}
{!! Minify::javascript('/js/contrato.js') !!}


@endpush
