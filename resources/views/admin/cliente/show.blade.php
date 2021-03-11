@extends('layouts.mastertop')

@section('content')


    <!-- Modal -->
    <div class="modal fade custom-modal" data-backdrop="static" id="modal-sucess" tabindex="1" role="dialog"
         aria-labelledby="customModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 600px">
            <div class="modal-content">
                <div class="modal-header-delete">
                    <h3><i class="fa fa-trash-o"></i> Excluir Cliente</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-body">
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <p>{{ $cliente->nomeRazaoSocial }}</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Cpf/Cnpj:</label>
                                            <p>{{ isset($cliente->cpfCnpj) ? $cliente->cpfCnpj : 'Não Informado' }}</p>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['route' => ['pessoa.destroy', $cliente->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Excluir', ['class' => 'btn flat btn-primary']) !!}
                    <a href="{{ route('pessoa.index') }}" class="btn btn-primary flat">Voltar</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('datatables-css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pikeadmin/css/style.css') }}">
@endpush

@push('datatables-script')
    <!-- DataTables -->
    <script src="{{ asset('pikeadmin/components/popper/popper.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#modal-sucess').modal('show');
        });
    </script>
@endpush
