    $(function () {

        getReceitaSelect();

        $('[data-mask]').inputmask();

    });

    function PreloadingStart(titulo){''
        startAnimation();
        $('#modalTitulo').html(titulo);
        $('#modal-default').modal('show');
    };

    function PreloadingStop(){
        stopAnimation();
        $('#modal-default').modal('toggle');

    };

    function validacaoForm() {

        var retorno = true;

        if(getDataTable('tabelaClientes').length === 0 ){
            toastr.error('Você deve adicionar ao menos um cliente para gerar o contrato');
            retorno = false;
        }

        if(getDataTable('tabelaReceitas').length === 0 ){
            toastr.error('Você deve adicionar ao menos uma Receita para gerar o contrato');
            retorno = false;
        }

        if ($('#numParcelas').val() < 0) {
            toastr.error('O Numero de Parcelas não pode ser menor que 0');
            retorno = false;
        }

        return retorno;
    };

    function getReceitaSelect() {

        receitas = null;
        $.ajax({
            type: "GET",
            url: "/getReceitaSelect",
            success: function(data) {
                if(data != null){
                    receitas = data;
                    var selectBox = $('#receitaSelect');
                    selectBox.find('option').remove();
                    $.each(data, function(i, d){
                        $('<option>').val(d.id).text(d.descricao).appendTo(selectBox);
                    });
                    $('#valorContrato').val(data[0].valor);
                }else {
                    toastr.warning('Receitas não encontradas', 'Atenção');
                }
            },
            error: function (msg) {
                toastr.error("Error ao Carregar as Receitas");
            }
        });
    };

    $('#receitaSelect').change(function (){
        var idReceita = $(this).val();

        $.each(receitas, function(i, d){
            if((idReceita) == d.id){
                $('#valorContrato').val(d.valor);
            }
        });

    });

    function getPessoaContrato() {

        if($('#cpfCnpj').val() != "") {
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '/ContratoPessoa/' + $('#cpfCnpj').val().replace(/\D/g,""),
            success: function(pessoaContrato) {

                if(pessoaContrato[0] != null){
                    $('#pessoasDados').append('<tr>' +
                        '<td>' + pessoaContrato[0].nomeRazaoSocial + '</td>' +
                        '<td>' + pessoaContrato[0].cpfCnpj + '</td>' +
                        '<td style="text-align: left">' +
                                '<a href="javascript:void(0)" onclick="deleteRowClientes(this.parentNode.parentNode.rowIndex)" > <i class="fa fa-trash text-red"></i></a>' +
                                '</td>'+
                        '<td style="display: none">' + pessoaContrato[0].id + '</td>' +
                        '</tr>');

                        $('#linha').show();
                        $('#dados').show();

                }else {
                    toastr.warning("Cliente não Encontrado", "Atenção");
                }
            }
        });

        }else{
            toastr.warning("CPF ou CNPJ é Obrigatório", "Atenção");
        }

        $('#cpfCnpj').val('');
        $('#cpfCnpj').focus();

    };

    function addReceita(){
        var valor = parseFloat($('#valorContrato').val()) || 0;
        var valorTotal = parseFloat($('#valorTotalContrato').val()) || 0;

        if($('#valorContrato').val() > 0){
            $('#receitasDados').append('<tr>' +
                    '<td>' + $('#receitaSelect :selected').text() + '</td>' +
                    '<td>' + $('#valorContrato').val() + '</td>' +
                    '<td style="text-align: left">' +
                        '<a href="javascript:void(0)" onclick="deleteRowReceitas(this.parentNode.parentNode.rowIndex, ' + valor + ')">' +
                        '<i class="fa fa-trash text-red"></i></a>' +
                        '</td>'+
                    '<td style="display: none" >' + $('#receitaSelect').val() + '</td>' +
                    '</tr>');

                    var valorTotalContrato = valor + valorTotal;
                    $('#valorTotalContrato').val(valorTotalContrato);
        }else {

            toastr.error('O Valor é Obrigatório');
        }

    };

    function gerarContasReceber(contrato) {

        $.ajax({
            type: "GET",
            url: '/contasReceberContrato/' + contrato['contrato'].id + '/' + contrato['dataVencEntrada'],
            beforeSend: PreloadingStart('Gerando Contas a Receber Aguarde...'),
            success: function (data) {
                if(data['success']){
                    PreloadingStop();
                    window.location.replace("/contrato");
                }else{
                    toastr.error(data['messages']);
                    PreloadingStop();
                }
            },
            error: function(data) {
                PreloadingStop();
                toastr.error("Erro Critico ao tentar cadastrar as contas a receber" . data);
            }
        });
    };

    function btnSalvar() {

        if (validacaoForm()) {

            document.getElementById("btnSalvarr").disabled = true;

            $("#cliente").val(JSON.stringify(getDataTable('tabelaClientes')));
            $("#receita").val(JSON.stringify(getDataTable('tabelaReceitas')));

            var dados = $("#frmContrato").serialize();

                $.ajax({
                    type: "post",
                    url: "/contrato",
                    data: dados,
                    beforeSend: PreloadingStart('Gerando Contrato Aguarde...'),
                    success: function (data) {
                        if(data['success']){
                            PreloadingStop();
                            gerarContasReceber(data);

                        }else{
                            PreloadingStop();
                            toastr.error(data['messages']);

                            document.getElementById("btnSalvarr").disabled = false;
                        }
                    },
                    error: function(data) {

                        PreloadingStop();

                        document.getElementById("btnSalvarr").disabled = false;

                        if(data.responseJSON.errors.objetoContrato)
                        toastr.error(data.responseJSON.errors.objetoContrato[0]);

                        if(data.responseJSON.errors.valorContrato)
                            toastr.error(data.responseJSON.errors.valorContrato[0]);

                        if(data.responseJSON.errors.valorEntradaContrato)
                            toastr.error(data.responseJSON.errors.valorEntradaContrato[0]);

                        if(data.responseJSON.errors.comarcaCidadeContrato)
                            toastr.error(data.responseJSON.errors.comarcaCidadeContrato[0]);

                        if(data.responseJSON.errors.comarcaEstadoContrato)
                            toastr.error(data.responseJSON.errors.comarcaEstadoContrato[0]);

                        if(data.responseJSON.errors.numParcelaContrato)
                            toastr.error(data.responseJSON.errors.numParcelaContrato[0]);

                        if(data.responseJSON.errors.dataVencContrato)
                            toastr.error(data.responseJSON.errors.dataVencContrato[0]);

                        if(data.responseJSON.errors.dataVencEntrada)
                            toastr.error(data.responseJSON.errors.dataVencEntrada[0]);


                    }
            });
        }
    };

    //EXCLUIR LINHA DA TABELA CLIENTES
    function deleteRowClientes(i){
        document.getElementById('tabelaClientes').deleteRow(i);
    };

    //EXCLUIR LINHA DA TABELA RECEITAS
    function deleteRowReceitas(i, v){

        var valorTotal = parseFloat($('#valorTotalContrato').val()) || 0;
        $('#valorTotalContrato').val(valorTotal - v);
        document.getElementById('tabelaReceitas').deleteRow(i);

    };

    //BUSCAR CLIENTE POR CPF
    function getDataTable(tabelaSave) {

        //PEGAR OS CLIENTES DA TABELA
        var indices = [];
        var arrayItens = [];

        //Pega os indices
        $('#' + tabelaSave + ' thead tr th').each(function() {
            indices.push($(this).text());
        });


        //Pecorre todos os produtos
        $('#' + tabelaSave + ' tbody tr').each(function( index ) {

        var obj = {};

        //Controle o objeto
        $(this).find('td').each(function( index ) {
            obj[indices[index]] = $(this).text();
        });

        //Adiciona no arrray de objetos
        arrayItens.push(obj);

        });

        return arrayItens;
    };
    //EXECUTA APOS TROCAR O CHECK FISICA
    $("#fisica").change(function() {

        if ($(this).val() == 1) {

           $('#cpfCnpj').inputmask("999.999.999-99");
           document.getElementById("cpfCnpj").placeholder = "CPF";

           $('#tipoPessoa').val(1);
        }
    });

     //EXECUTA APOS TROCAR O CHECK JURIDICA
     $("#juridica").change(function() {

        if ($(this).val() == 2) {

            $('#cpfCnpj').inputmask("99.999.999/9999-99");
            document.getElementById("cpfCnpj").placeholder = "CNPJ";

            $('#tipoPessoa').val(2);
        }
     });

     //VERIFICA O CHECK SELECIONADO E EXECUTA AÇÃO FISICA

    if(document.getElementById("fisica").checked == true){

        $('#cpfCnpj').inputmask("999.999.999-99");
        document.getElementById("cpfCnpj").placeholder = "CPF";

        $('#tipoPessoa').val(1);

        //VERIFICA O CHECK SELECIONADO E EXECUTA AÇÃO JURIDICA
    } else if(document.getElementById("juridica").checked == true){

        $('#cpfCnpj').inputmask("99.999.999/9999-99");
        document.getElementById("cpfCnpj").placeholder = "CNPJ";

        $('#tipoPessoa').val(2);
    };
