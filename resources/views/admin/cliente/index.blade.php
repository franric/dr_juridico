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
                <a class="btn btn-primary btn-flat pull-right"
            href="{{ route('pessoa.create') }}"><i class="fa fa-plus"></i>&nbsp; Cadastrar</a>
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
                  <h3 class="card-title"><i class="fa fa-user"></i> Lista de Clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="table_blue">
                    <tr>
                        <th>Cliente</th>
                        <th>CPF/CNPJ</th>
                        <th>Profissão</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                <tbody>
                    @if(isset($clientes))
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->nomeRazaoSocial }}</td>
                                    <td>{{ $cliente->cpfCnpj  }}</td>
                                    <td>{{ isset($cliente->profissao) ? $cliente->profissao : 'Não Informado' }}</td>
                                    <td>{{ isset($cliente->email) ? $cliente->email : 'Não Informado' }}</td>
                                    <td>{{ $cliente->celUm }}</td>
                                    <td style="text-align: center">

                                    @if($cliente->status == 1)
                                            <span class="badge bg-green">ATIVO</span></td>
                                    @else
                                        <span class="badge bg-red">INATIVO</span></td>
                                    @endif
                                    <td style="text-align: center">
                                        <div style="margin-right:5px" class="btn-group">
                                            <a href="{{ route('pessoa.edit', $cliente->id) }}"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Editar Registro"> <i
                                                        class='fa fa-pencil-alt text-primary'></i></a>
                                        </div>
                                        <div style="margin-right:5px" class="btn-group">
                                            <a href="javascript:void(0)" onclick="getDelete({{ $cliente->id }})"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Excluir Registro"> <i
                                                        class='fa fa-trash text-red'></i></a>
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

<div class="modal fade" id="modal-success">
        <div class="modal-dialog">
          <div class="modal-content bg-default">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Excluir Cliente</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <!-- /.col -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nome:</label>
                                                <p id="nome"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cpf/Cnpj:</label>
                                                <p id="cpfCnpj"></p>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Voltar</button>
                <button type="button" onclick="Delete()" class="btn btn-primary" >Excluir</button>
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
    {!! Minify::javascript('/js/Pessoa.js') !!}

<script>
    $(function () {
        $("#example1").DataTable(
            {
                "language": {
                    "url": "/adminlte/comp/datatables.net/js/ptBr.lang"
                }
            }
        );
    });
</script>
@endpush
