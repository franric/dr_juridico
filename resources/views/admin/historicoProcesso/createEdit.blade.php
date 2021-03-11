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

                    @if(isset($procuracao))
                    <div class="card-header">
                        <h3 class="card-title"><i class="nav-icon fa fa-list"> </i> Alterar Historico</h3>
                    </div>
                    {!! Form::model($procuracao, ['route' => ['historicoProcesso.update', $procuracao->id], 'method' =>
                    'put']) !!}
                    @else
                    <div class="card-header">
                        <h3 class="card-title"><i class="nav-icon fa fa-list"> </i> Cadastrar Historico</h3>
                    </div>
                    {!! Form::open(['route' => 'historicoProcesso.store', 'method' => 'post']) !!}
                    @endif

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-2">
                                <label>Contrato</label>
                                <select name="contrato_id" class="form-control select2" id="contratoSelect"
                                    style="width: 100%;">

                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Titulo</label>
                                {!! Form::text('titulo', $value = null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-3">
                                    <label>Data</label>
                                    {!! Form::date('dataTarefa', $value = null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Hora</label>
                                    {!! Form::time('horaTarefa', $value = null, ['class' => 'form-control']) !!}
                                </div>

                            <div class="form-group col-md-12">
                                <label>Tarefa</label>
                                {!! Form::textarea('tarefa', $value = null, ['class' => 'form-control']) !!}
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        {!! Form::submit(isset($historicoProcesso) ? 'Alterar' : 'Salvar', ['class' => 'btn flat btn-primary'])
                        !!}
                        <a href="{{ route('historicoProcesso.index') }}" class="btn flat btn-primary">Fechar</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@push('datatables-css')
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
{!! Minify::javascript('/js/historicoProcesso.js') !!}

@include('layouts.alerts.validationAlert')

@endpush


