@extends('layouts.mastertop')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1>Text Editors</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Text Editors</li> -->
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                 <h3 class="card-title"> <i class="fas fa-pen-alt"></i> Adicione o Cliente para o Historico</h3>
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
                                <input type="radio" name="tipoPessoa" value=2 name="tipoPessoa" id="juridica">
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
                            <input type="button" onclick="getPessoaContrato()" value="Buscar" class="btn flat btn-info">
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
                                                <th style="display: none">codigoCliente</th>
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                    @if(isset($historico))
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen-alt"> </i> Alterar Histórico</h3>
                    </div>
                    {!! Form::model($historico, ['id' => 'frmHistorico']) !!}
                    @else
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-balance-scale"> </i> Escrever Histórico</h3>
                    </div>
                    {!! Form::open(['id' => 'frmHistorico']) !!}
                    {!! Form::hidden('id', $value = null) !!}
                    @endif
                <!-- /.card-header -->
                <div class="card-body pad">
                    <div class="mb-2">
                    {!! Form::textarea('historico', $value = null, ['placeholder' => 'Histórico do Cliente',  'style' => 'width: 100%; height: 300px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;' ]) !!}

                    {!! Form::hidden('cliente[]', $value = null, ['id' => 'cliente']) !!}

                    </div>
                <div class="card-footer">
                    @if(isset($historico))
                        {!! Form::button('Alterar', ['class' => 'btn flat btn-primary',
                        'id' => 'btnSalvarr', 'onclick' => 'btnSalvar(' . $historico->id . ')']) !!}
                    @else
                        {!! Form::button('Salvar', ['class' => 'btn flat btn-primary',
                        'id' => 'btnSalvarr', 'onclick' => 'btnSalvar(0)']) !!}
                    @endif

                    <a href="{{ route('historico.index') }}" class="btn flat btn-primary">Fechar</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.col-->
    </div>
    <!-- ./row -->

</section>

@endSection

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

<!-- summernote -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.css') }}">
@endpush

@push('datatables-script')
<!-- Select2 -->
{!! Minify::javascript('/adminlte/plugins/select2/js/select2.full.min.js') !!}
<!-- InputMask -->
{!! Minify::javascript('/adminlte/plugins/inputmask/jquery.inputmask.bundle.js') !!}
{!! Minify::javascript('/adminlte/plugins/moment/moment.min.js') !!}
<!-- bootstrap color picker -->
{!! Minify::javascript('/adminlte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') !!}

<!-- Summernote -->
{!! Minify::javascript('/adminlte/plugins/summernote/summernote-bs4.min.js') !!}
{!! Minify::javascript('/js/historico.js') !!}

<script>
    @if(isset($historico))

        @foreach ($historico->Pessoa as $pessoa)
            $('#pessoasDados').append('<tr>' +
                '<td> {{ $pessoa->nomeRazaoSocial }} </td>' +
                '<td> {{ $pessoa->cpfCnpj }} </td>' +
                '<td style="text-align: left">' +
                        '<a href="javascript:void(0)" onclick="deleteRowClientes(this.parentNode.parentNode.rowIndex)" > <i class="fa fa-trash text-red"></i></a>' +
                        '</td>'+
                '<td style="display: none"> {{ $pessoa->id }} </td>' +
                '</tr>');
        @endforeach
    @endif

</script>

@endpush
