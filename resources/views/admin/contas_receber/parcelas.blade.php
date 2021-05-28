@extends('layouts.mastertop')


@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            @include('layouts.alerts.validationAlert')
        <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">

            <a href="{{ route('contasReceber.index') }}" class="btn btn-primary">Voltar</a>
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
                  <h3 class="card-title"><i class="fa fa-dollar-sign"></i> Parcelas do Contrato Nº {{ isset($numContrato) ?  $numContrato : "000000"}} - {{ $cliente }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="table_blue">
                    <tr>
                        <th>Parcela</th>
                        <th>Valor Parcela</th>
                        <th>Vencimento</th>
                        <th>Valor Recebido</th>
                        <th>Recebimento</th>
                        <th>Forma de Pagamento</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                <tbody>
                    @if(isset($parcelas))
                            @foreach($parcelas as $parcela)

                                @if($parcela->statusRecebimento == 1 && $parcela->dataVencimento < date('Y-m-d'))
                                    <tr class="text-danger" >
                                @elseif ($parcela->statusRecebimento == 0)
                                    <tr class="text-success" >
                                @elseif($parcela->dataVencimento >= date('Y-m-d'))
                                    <tr class="text-primary" >
                                @endif
                                    <td class="text-center">{{ $parcela->numeroParcela }}</td>
                                    <td class="text-right">R$ {{ number_format($parcela->valorParcela, 2, ',', '.') }}</td>
                                    <td class="text-center"> {{ date('d/m/Y', strtotime($parcela->dataVencimento)) }}</td>
                                    <td class="text-right">R$ {{ number_format($parcela->valorRecebido, 2, ',', '.') }}</td>
                                    <td class="text-center">{{ isset($parcela->dataRecebimento) ? date('d/m/Y', strtotime($parcela->dataRecebimento)) : "-" }}</td>
                                    <td class="text-center">
                                        @if($parcela->statusRecebimento == 1 && $parcela->dataVencimento < date('Y-m-d'))
                                            <span class="badge bg-danger">VENCIDA</span></td>
                                        @elseif($parcela->statusRecebimento == 0)
                                            <span class="badge bg-green">PAGO</span></td>
                                        @elseif($parcela->dataVencimento >= date('Y-m-d'))
                                            <span class="badge bg-primary">AGUARDANDO PAGAMENTO</span></td>
                                        @endif

                                    <td class="text-center">
                                        @if(isset($parcela->FormaPagamento) && count($parcela->FormaPagamento) > 0)
                                            @foreach($parcela->FormaPagamento as $fp)
                                                <span class="badge bg-primary">{{ $fp->descricao }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-warning">AGUARDANDO PAGAMENTO</span>
                                        @endif

                                    </td>

                                    <td style="text-align: center">
                                            @if($parcela->statusRecebimento == 1)
                                                <div style="margin-right:5px" class="btn-group">
                                                    <a href="javascript:void(0)" onclick="finalizarPagamento({{ $parcela }})"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Visualizar Parcelas">
                                                    <i class="fas fa-dollar-sign"></i></a>
                                                </div>
                                            @else
                                            <div style="margin-right:5px" class="btn-group">
                                                <a data-placement="top" <i class="fas fa-check-circle"></i></a>
                                            </div>
                                            <div style="margin-right:5px" class="btn-group">
                                                <a href="{{ url('imprimirRecibo', $parcela->id) }}"
                                                data-toggle="tooltip" data-placement="top"
                                                title="ImprimirRecibo">
                                                <i class="fas fa-money-check-alt text-warning"></i></a>
                                            </div>
                                            @endif
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

<div class="modal fade" id="modal-pagamento" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content bg-default">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Pagar Parcela</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
                <div class="modal-body">
                    <div class="card-body">
                        {!! Form::open(['route' => 'contasReceber.finalizarPagamento', 'method' => 'post']) !!}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Valor Parcela</label>
                                    <p class="text-danger text-bold" id="valorParcela"></p>
                                </div>

                            </div>


                            <div class="row">
                                <div class="form-group col-md-12">
                                        <label>Forma de Pagamento</label>
                                        {!! Form::select('tipoPagamento', $formaPagamento, null, ['class' => 'form-control select2', 'id' => 'tipoPagamento']) !!}
                                    </div>
                            </div>

                            <div class="row">
                                    <div class="form-group col-md-12">
                                            <label>Valor a Receber</label>
                                            {!! Form::number('valorRecebido', $value = null, ['class' => 'form-control', 'id' => 'valorRecebido']) !!}
                                        </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Data Recebimento</label>
                                    {!! Form::date('dataRecebimento', $value = null, ['class' => 'form-control', 'id' => 'dataRecebimento']) !!}

                                    {!! Form::hidden('id', $value = null, ['id' => 'idParcela']) !!}
                                    {!! Form::hidden('statusRecebimento', $value = 0) !!}

                                </div>
                            </div>


                    </div>
                </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Voltar</button>
                <!--<button type="button" onclick="pagarParcela()" class="btn btn-primary" >Pagar</button>-->
                {!! Form::submit('Salvar', ['class' => 'btn flat btn-primary']) !!}
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
    {!! Minify::javascript('/js/funcoes.js') !!}

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

        function finalizarPagamento(parcela) {

            $('#modal-pagamento').modal('show');
            $('#valorParcela').html(mascaraValor(parcela.valorParcelaJuros));
            $('#idParcela').val(parcela.id);
            $('#contratoId').val(parcela.contrato_id);

        }



    </script>

@endpush

