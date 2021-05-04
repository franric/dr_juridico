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
                        <a class="btn btn-primary btn-flat pull-right" href="{{ route('contrato.create') }}"><i
                                class="fa fa-plus"></i>&nbsp; Gerar Contrato</a>
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
                    <h3 class="card-title"><i class="fa fa-balance-scale"></i> Lista de Contratos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="table_blue">
                            <tr>
                                <th>Numero</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Parcelas</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($contrato))


                            @foreach($contrato as $contratos)
                            <tr>
                                <td style="vertical-align: middle">{{ $contratos->numContrato }}</td>
                                <td style="vertical-align: middle">

                                    @foreach ($contratos->Pessoa as $pessoa)


                                        <p class="text-left">
                                            <span>{{ $pessoa->nomeRazaoSocial }}</span>
                                        </p>

                                    @endforeach

                                </td>
                                <td style="vertical-align: middle" class="text-right float-none">R$
                                    {{ number_format($contratos->valorContrato, 2, ',', '.') }}
                                </td>
                                <td style="vertical-align: middle" class="text-center">
                                    {{ date("d/m/Y", strtotime($contratos->created_at)) }}</td>
                                <td style="vertical-align: middle" class="text-center">
                                    {{ $contratos->numParcelaContrato }}</td>
                                <td style="vertical-align: middle" style="text-align: center">

                                    @if($contratos->statusContrato == 1)
                                    <span class="badge bg-warning">ABERTO</span></td>
                                @else
                                <span class="badge bg-green">FECHADO</span></td>
                                @endif
                                <td style="text-align: center; vertical-align: middle">
                                <!--<div style="margin-right:5px" class="btn-group">
                                        <a href="{{ route('contrato.edit', $contratos->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Editar Registro"> <i
                                                class='fa fa-pencil-alt text-primary'></i></a>
                                    </div>
                                    <div style="margin-right:5px" class="btn-group">
                                        <a href="{{ route('contrato.show', $contratos->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Excluir Registro"> <i
                                                class='fa fa-trash text-red'></i></a>
                                    </div>-->
                                    <div style="margin-right:5px" class="btn-group">
                                        <a href="{{ url('contratoView', $contratos->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Visualizar Contrato"> <i
                                                class='fa fa-file-archive text-success'></i></a>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>
@endsection

@push('datatables-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endpush

@push('datatables-script')
<!-- DataTables -->

{!! Minify::javascript('/adminlte/plugins/datatables/jquery.dataTables.js') !!}
{!! Minify::javascript('/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') !!}

<script>
        $("#example1").DataTable({

                "language": {
                    "url": "/adminlte/comp/datatables.net/js/ptBr.lang"
                },
                "pageLength": 20,
                "lengthMenu": [[20,50,100,-1],[20, 50, 100, "All"]]
        });
</script>

@endpush
