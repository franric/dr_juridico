$(function () {
    $("#example1").DataTable(
        {
            "language": {
                "url": "/adminlte/comp/datatables.net/js/ptBr.lang"
            }
        }
    );

});

function getDelete(id) {

    $.ajax({
        type: 'GET',
        url: '/historico/' + id,
        success: function (data) {
            $('#modal-excluir').modal('show');
            $('#nome').html(data[0].nomeRazaoSocial);
            $('#idHisto').val(idHistorico = data[0].pivot.historico_id);
        }
    });
};

function getHistoricoContrato(historico)
{    
    $('#modal-contrato').modal('show');;
    $('#idHistorico').val(historico.id);
    $('#nomeHistorico').html(historico.pessoa[0].nomeRazaoSocial);
    getContratosSelect();
}

function getContratosSelect() {

    var selectBox = $('#contratoSelect');

    $.ajax({
        type: "GET",
        url: "/getContratosSelect",
        success: function(data) {
            if(data != null){                
                selectBox.find('option').remove();
                $.each(data, function(i, d){
                    $('<option>').val(d.id).text(d.numContrato).appendTo(selectBox);
                });
            }else {
                toastr.warning('Contratos não encontrados', 'Atenção');
                $('<option>').val(d.id).text('Contratos não Encontrado').appendTo(selectBox);
            }
        },
        error: function (msg) {            
            toastr.error("Error ao Carregar os Contratos");    
            $('<option>').val(0).text('Contratos não Encontrado').appendTo(selectBox);        
        }
    });
};

function validacaoForm() {

    var retorno = true;

    if(getDataTable('tabelaClientes').length === 0 ){
        toastr.error('Você deve adicionar ao menos um cliente para gerar o contrato');
        retorno = false;
    }

    return retorno;
};

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

function btnSalvar(idHistorico) {

    var tipo = 'POST';
    var path = '/historico';

    if (validacaoForm()) {

        if(idHistorico > 0 ){
            tipo = 'PUT';
            path = '/historico/' + idHistorico;
        }

        $("#cliente").val(JSON.stringify(getDataTable('tabelaClientes')));

        var dados = $("#frmHistorico").serialize();

            $.ajax({
                type: tipo,
                url: path,
                data: dados,
                //beforeSend: PreloadingStart('Gerando Contrato Aguarde...'),
                success: function (data) {
                    if(data['success']){
                        //PreloadingStop();
                        window.location.replace("/historico");
                    }else{
                        toastr.error(data['messages']);
                        //PreloadingStop();
                    }
                },
                error: function(data) {
                    //PreloadingStop();
                    if(data.responseJSON.errors.historico)
                    toastr.error(data.responseJSON.errors.historico[0]);
                }
        });
    }
};

function btnSalvarContratoHistorico() {   
  
    var dados = $("#frmHistoricoContrato").serialize();
console.log(dados);
    $.ajax({
        type: 'post',
        url: '/contratoHistorico/',
        data: dados,
        //beforeSend: PreloadingStart('Gerando Contrato Aguarde...'),
        success: function (data) {
            if(data['success']){
                //PreloadingStop();
                window.location.replace("/historico");
            }else{
                toastr.error(data['messages']);
                //PreloadingStop();
            }
        },
        error: function(data) {
            //PreloadingStop();
            if(data.responseJSON.errors.historico)
            toastr.error(data.responseJSON.errors.historico[0]);
        }
    });

};

//EXCLUIR LINHA DA TABELA CLIENTES
function deleteRowClientes(i){
    document.getElementById('tabelaClientes').deleteRow(i);
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