$(function () {
    

    getClientesSelect();

});

function getClientesSelect() {

    var selectBox = $('#clienteSelect');

    $.ajax({
        type: "GET",
        url: "/getClienteSelect",
        success: function(data) {
            if(data != null){                
                selectBox.find('option').remove();
                $.each(data, function(i, d){
                    $('<option>').val(d.id).text(d.cpfCnpj).appendTo(selectBox);
                });
            }else {
                toastr.warning('Clientes não encontrados', 'Atenção');
                $('<option>').val(d.id).text('Cliente não Encontrado').appendTo(selectBox);
            }
        },
        error: function (msg) {            
            toastr.error("Error ao Carregar as Clientes");    
            $('<option>').val(0).text('Cliente não Encontrado').appendTo(selectBox);        
        }
    });
};