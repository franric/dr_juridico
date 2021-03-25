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
                <div class="col-lg-6 col-6">
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
                <div class="col-lg-6 col-6">
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
                <div class="col-lg-6 col-6">
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
                  <div class="col-lg-6 col-6">
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

                <div class="col-lg-3 col-6">
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
                <div class="col-lg-6 col-6">
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
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3>{{ $dashboard['cliente'] }}</h3>

                      <p>Clientes</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                    <a class="small-box-footer"><i class="fas fa-check-circle"></i></a>
                  </div>
                </div>
                <!-- ./col -->
            </div>
            </div>
        </div>

@endsection