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
            href="{{ route('receita.create') }}"><i class="fa fa-plus"></i> Cadastrar</a>
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
                  <h3 class="card-title"><i class="fa fa-dollar-sign"></i> Lista de Receitas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="table_blue">
                        <tr>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                        <tbody>
                        @if(isset($receita))
                            @foreach($receita as $receita)
                                <tr>
                                    <td>{{ $receita->descricao }}</td>
                                    <td>{{ $receita->valor }}</td>

                                    <td style="text-align: center">
                                        <div style="margin-right:5px" class="btn-group">
                                            <a href="{{ route('receita.edit', $receita->id) }}"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Editar Registro"><i class='fa fa-pencil-alt text-primary'></i>
                                            </a>
                                        </div>
                                        <div style="margin-right:5px" class="btn-group">
                                            <a href="{{ route('receita.show', $receita->id) }}"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Excluir Registro"> <i class='fa fa-trash text-red'></i>
                                            </a>
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
@endsection

@push('datatables-css')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endpush

@push('datatables-script')
    <!-- DataTables -->

    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>


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

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover()
        })

      </script>

@endpush
