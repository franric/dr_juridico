@extends('layouts.mastertop')

@section('content')

<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-12">
                <div class="col-sm-3"></div>
            <div class="col-sm-6">
                    @include('layouts.alerts.validationAlert')
              <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
            </div><!-- /.col -->
            <div class="col-sm-3">
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

        <div class="col-md-3"></div>
        <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <!-- form start -->
            @if(isset($formaPagamento))
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user-circle"> </i> Alterar Forma de Pagamento</h3>
                </div>
                {!! Form::model($formaPagamento, ['route' => ['formaPagamento.update', $formaPagamento->id], 'method' => 'put']) !!}.
                {!! Form::hidden('id', $value = null) !!}
            @else
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user-circle"> </i> Cadastrar Forma de Pagamento</h3>
                </div>
                {!! Form::open(['route' => 'formaPagamento.store', 'method' => 'post']) !!}

            @endif

                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-12">
                            <label>Descri????o da Forma de Pagamento</label>
                            {!! Form::text('descricao', $value = null, ['class' => 'form-control', 'autofocus', 'onkeyup' => 'maiuscula(this)']) !!}
                        </div>

                </div>

                </div>
                <div class="modal-footer">
                    {!! Form::submit(isset($formaPagamento) ? 'Alterar' : 'Cadastrar', ['class' => 'btn flat btn-primary']) !!}
                    <a href="{{ route('formaPagamento.index') }}"
                       class="btn btn-primary flat">Fechar</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</section>

@endsection

@push('datatables-script')

    <script src="{{ asset('js/funcoes.js') }}"></script>

@endpush
