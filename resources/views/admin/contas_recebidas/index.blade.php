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
                  <h3 class="card-title"><i class="fa fa-dollar-sign"></i>&nbsp; Contas Recebidas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="table_blue">
                    <tr>
                        <th>Contrato</th>
                        <th>Cliente</th>
                        <th>Valor Contrato</th>
                        <th>Valor Recebido</th>
                        <th>Valor a Receber</th>
                        <th>Parcelas</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                <tbody>
                    @if(isset($contasRecebidas))
                            @foreach($contasRecebidas as $recebido)
                                <tr>
                                    <td>{{ $recebido->numContrato }}</td>
                                    <td>
                                        @foreach($recebido->Pessoa as $pessoa)
                                            <p class="text-left">
                                                <span>{{ $pessoa->nomeRazaoSocial }}</span>
                                            </p>
                                        @endforeach
                                    </td>
                                    <td> R$ {{ number_format($recebido->valorContrato, 2, ',', '.') }}</td>
                                    <td class="text-success text-right text-bold">R$ {{ number_format($recebido->valorPago, 2, ',', '.') }}</td>

                                    <td class="text-danger text-right text-bold">R$ {{ number_format($recebido->valorReceber, 2, ',', '.') }}</td>
                                    <td class="text-center">{{ $recebido->numParcelaContrato }}</td>


                                    <td style="text-align: center">
                                        <div style="margin-right:5px" class="btn-group">
                                            <a href="{{ route('parcela', $recebido->id) }}"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Visualizar Parcelas">
                                               <i class="fas fa-dollar-sign text-primary"></i></a>
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


