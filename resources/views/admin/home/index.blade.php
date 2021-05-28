@extends('layouts.mastertop')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
            <div class="container-fluid">
              <!-- Small boxes (Stat box) -->

            <div class="row">

                <div class="col-lg-2 col-2">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>R$ {{ number_format($dashboard['recebidoAnual'], 2, ',', '.') }}</h3>

                        <p>Recebido Anual</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                      <a href="#" class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-2">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                      <div class="inner">
                        <h3>R$ {{ number_format($dashboard['aReceberMensal'], 2, ',', '.') }}</h3>

                        <p>A Receber Mensal</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                      <a href="#" class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->

                <div class="col-lg-2 col-2">
                  <!-- small box -->
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3>R$ {{ number_format($dashboard['recebidoMensal'], 2, ',', '.') }}</h3>

                      <p>Recebidos Mensal</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                  </div>
                </div>
                <!-- ./col -->

                  <div class="col-lg-2 col-2">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                      <div class="inner">
                        <h3>R$ {{ number_format($dashboard['aReceberAnual'], 2, ',', '.') }}</h3>

                        <p>A Receber Anual</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                      <a href="#" class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-2 col-2">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>R$ {{ number_format($dashboard['emAtraso'], 2, ',', '.') }}</h3>

                        <p>Em atraso</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                      <a href="#" class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->


                <div class="col-lg-2 col-2">
                  <!-- small box -->
                  <div class="small-box bg-primary">
                    <div class="inner">
                      <h3>{{ $dashboard['contrato'] }}</h3>

                      <p>Contratos Abertos</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-balance-scale"></i>
                    </div>
                    <a class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                  </div>
                </div>
                <!-- ./col -->
            </div>

            <!--  ####################### CLIENTES ATRASADOS ################################## -->
            <div class="card">
                <div class="card-header bg-danger">
                  <h3 class="card-title ">CLIENTES EM ATRASO</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-sm">
                    <thead>
                      <tr >
                        <th>Contrato Nº</th>
                        <th>Clientes</th>
                        <th>Parcelas em Atraso</th>
                        <th style="width: 150px">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($dashboard['clientesAtraso'] as $atraso)
                            <tr>
                                <td>{{ $atraso[0]->Contrato->numContrato }}</td>
                                <td>
                                    {{ $atraso[0]->Contrato->Pessoa[0]->nomeRazaoSocial }}
                                </td>
                                <td>
                                    {{ count($atraso) }}
                                </td>
                                <td style="text-align: right" ><span class="badge bg-danger">R$ {{ number_format(collect($atraso)->sum('valorParcela'), 2, ',', '.') }}</span></td>
                            </tr>
                        @endforeach
                    <tr class="bg-primary">
                        <td colspan="3">TOTAL DEVIDO</td>
                        <td style="text-align: right">R$ {{ number_format($dashboard['clientesAtrasoValorTotal'], 2, ',', '.') }}  </td>
                    </tr>

                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

              <div class="col-md-6">
              <!-- BAR CHART -->
            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Recebidos x A Receber</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

            </div>

        </div>

@endsection

@push('datatables-script')

{!! Minify::javascript('/adminlte/plugins/chart.js/Chart.min.js') !!}

    <script>
        $(function () {

        var areaChartData = {
        labels  : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
        datasets: [
        {
            label               : 'Recebidos',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
            label               : 'A Receber',
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

      //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          datasetFill             : false
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
    });
    </script>

@endpush

