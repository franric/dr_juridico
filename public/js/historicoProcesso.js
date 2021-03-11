$(function () {

    getContratoSelect();

});

function getContratoSelect() {

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
            $('<option>').val(0).text('Contrato não Encontrado').appendTo(selectBox);
        }
    });
};
