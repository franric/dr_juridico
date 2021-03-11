function maiuscula(z){
    v = z.value.toUpperCase();
    z.value = v;
}

function mascaraValor(valor) {

    valor = valor.toString().replace(/\D/g,"");
    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");

    return valor
}
