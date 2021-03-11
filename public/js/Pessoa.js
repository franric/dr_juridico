$(function () {

    $('[data-mask]').inputmask()
    $('#cpfRepresentante').inputmask("999.999.999-99");

});

$("#radioPrimary1").change(function () {

    $('#divpessoajuridica2').hide();
    $('#linha').hide();

});

$("#radioPrimary2").change(function () {

    $('#divpessoajuridica2').show();
    $('#linha').show();

});


$("#fisica").change(function () {

    if ($(this).val() == 1) {
        $('#divpessoajuridica1').hide();
        $('#divpessoajuridica2').hide();
        $('#nacionalidade').show();
        $('#estadoCivil').show();
        $('#profissao').show();
        $('#rg').show();
        $('#ctps').show();
        $('#orgExpedidor').show();
        $('#ufOrgExpedidor').show();
        $('#dataNascimento').show();
        $('#linha').hide();
        $('#represetanteFisica').show();

        $('#cpfCnpj').inputmask("999.999.999-99");

        $('#tipoPessoa').val(1);
    }

    if ($('#radioPrimary1').prop("checked")) {
        $('#divpessoajuridica2').hide();
    }

    if ($('#radioPrimary2').prop("checked")) {
        $('#divpessoajuridica2').show();
    }

});


$("#juridica").change(function () {

    if ($(this).val() == 2) {
        $('#divpessoajuridica1').show();
        $('#divpessoajuridica2').show();
        $('#nacionalidade').hide();
        $('#estadoCivil').hide();
        $('#profissao').hide();
        $('#rg').hide();
        $('#ctps').hide();
        $('#orgExpedidor').hide();
        $('#ufOrgExpedidor').hide();
        $('#dataNascimento').hide();
        $('#linha').show();
        $('#represetanteFisica').hide();

        $('#cpfCnpj').inputmask("99.999.999/9999-99");

        $('#tipoPessoa').val(2);
    }

});

if (document.getElementById("fisica").checked == true) {

    $('#divpessoajuridica1').hide();
    $('#divpessoajuridica2').hide();
    $('#nacionalidade').show();
    $('#estadoCivil').show();
    $('#profissao').show();
    $('#rg').show();
    $('#ctps').show();
    $('#orgExpedidor').show();
    $('#ufOrgExpedidor').show();
    $('#dataNascimento').show();
    $('#represetanteFisica').show();

    $('#cpfCnpj').inputmask("999.999.999-99");

    $('#tipoPessoa').val(1);

    if ($('#nomeRepresentante').val() != "") {
        $('#divpessoajuridica2').show();
        document.getElementById("radioPrimary2").checked = true;
    }

} else if (document.getElementById("juridica").checked == true) {
    $('#divpessoajuridica1').show();
    $('#divpessoajuridica2').show();
    $('#nacionalidade').hide();
    $('#estadoCivil').hide();
    $('#profissao').hide();
    $('#rg').hide();
    $('#ctps').hide();
    $('#orgExpedidor').hide();
    $('#ufOrgExpedidor').hide();
    $('#dataNascimento').hide();
    $('#represetanteFisica').hide();

    $('#cpfCnpj').inputmask("99.999.999/9999-99");

    $('#tipoPessoa').val(2);
}

function getDelete(id) {

    idPessoa = 0;

    $.ajax({
        type: 'GET',
        url: '/pessoa/' + id,
        success: function (data) {

            $('#modal-success').modal('show');
            $('#nome').html(data.nomeRazaoSocial);
            $('#cpfCnpj').html(data.cpfCnpj);
            idPessoa = data.id;
        }
    });
}

function Delete() {
    $.ajax({
        type: 'get',
        url: '/ExcluirCliente/' + idPessoa,
        success: function (data) {
            console.log(data['success']);
            if (data['success']) {
                $('#modal-success').modal('hide');
                toastr.success(data['messages']);
            } else {
                $('#modal-success').modal('hide');
                toastr.error(data['messages']);
            }
        }
    });
}
