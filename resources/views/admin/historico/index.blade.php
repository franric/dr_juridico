@extends('layouts.mastertop')


@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">

                    <div class="box-header with-border">
                        <a class="btn btn-primary btn-flat pull-right" href="{{ route('historico.create') }}"><i
                                class="fa fa-plus"></i>&nbsp; Cadastrar</a>
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
                    <h3 class="card-title"><i class="fas fa-pen-alt"></i> Historico de Clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="table_blue">
                            <tr>
                                <th>Cliente</th>
                                <th>Contrato</th>
                                <th>Data</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($historicos))
                            @foreach($historicos as $historico)
                            <tr>
                                <td style="vertical-align: middle">
                                    @foreach ($historico->Pessoa as $pessoa)
                                    <p class="text-left">
                                        <span>{{ $pessoa->nomeRazaoSocial }}</span>
                                    </p>
                                    @endforeach
                                </td>

                                <td class="text-center" style="vertical-align: middle">
                                    {{ ($historico->Contrato['numContrato']) ? $historico->Contrato['numContrato'] : 'Não Atrelado'   }}
                                </td>
                                <td class="text-center" style="vertical-align: middle">
                                    {{ date('d/m/Y', strtotime($historico->created_at)) }}</td>

                                <td style="text-align: center; vertical-align: middle">
                                    <div style="margin-right:5px" class="btn-group">
                                        <a href="{{ route('historico.edit', $historico->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Editar Registro"> <i
                                                class='fa fa-pencil-alt text-primary'></i></a>
                                    </div>
                                    <div style="margin-right:5px" class="btn-group">
                                        <a href="javascript:void(0)" onclick="getDelete({{ $historico->id }})"
                                            data-toggle="tooltip" data-placement="top" title="Excluir Registro"> <i
                                                class='fa fa-trash text-red'></i></a>
                                    </div>
                                    <div style="margin-right:5px" class="btn-group">
                                        <a href="javascript:void(0)" onclick="getHistoricoContrato({{ $historico }})"
                                            data-toggle="tooltip" data-placement="top" title="Adicionar Contrato"> <i
                                                class='fas fa-balance-scale text-success'></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-excluir">
    <div class="modal-dialog">
        <div class="modal-content bg-default">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Excluir Histórico Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Cliente:</label>
                                            <p id="nome"></p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="excluirHistorico" class="modal-footer justify-content-between">
                {!! Form::open(['route' => 'historico.excluir', 'method' => 'post']) !!}
                <input type="hidden" name="id" id="idHisto">
                <button type="submit" class="btn btn-primary">Excluir</button>
                {!! Form::Close() !!}
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-contrato">
    <div class="modal-dialog">
        <div class="modal-content bg-default">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Adicionar Contrato ao Histórico</h3>                    
                </div>                
                {!! Form::open(['id' => 'frmHistoricoContrato']) !!}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Cliente</label>
                            <p id="nomeHistorico"></p>                           
                        </div>
                        <div class="form-group">
                            <label>Selecione o Contrato</label>
                            <select name="contrato_id" class="form-control select2" id="contratoSelect" style="width: 100%;">

                            </select>                            
                            {!! Form::hidden('id', $value = null, ['id' => 'idHistorico']) !!}                        
                        </div>
                                               
                    </div>
                    <div class="card-footer">                        
                        {!! Form::button('Salvar', ['class' => 'btn btn-primary', 'onclick' => 'btnSalvarContratoHistorico()']) !!}
                    </div>                    
                {!! Form::close() !!}                    
            </div>
        </div>
    </div>
</div>

@endsection


@push('datatables-css')
<!-- DataTables -->
{!! Minify::stylesheet('/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') !!}
@endpush

@push('datatables-script')
<!-- DataTables -->

{!! Minify::javascript('/adminlte/plugins/datatables/jquery.dataTables.js') !!}
{!! Minify::javascript('/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') !!}
{!! Minify::javascript('/js/historico.js') !!}

@endpush