$('.cpf').mask('000.000.000-00');
$('.cep').mask('00000-000');
$('.uf').mask('SS');
$('.phone').mask('(00) 0000-0000');
$('.cellphone').mask('(00) 00000-0000');

$(document).on('blur', '#cep', function() { //quando ocorrer um blur no elemento cep
    const cep = $(this).val(); //const pra amarzenar o valor de cep
    
    $.ajax({ //requisicao assincrona, sem precisar recarregar a pagina
        url: 'https://viacep.com.br/ws/'+cep+'/json',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if(data.erro) {
                alert('Endereço não encontrado');
            }

            $('#uf').val(data.uf);
            $('#city').val(data.localidade);
            $('#street').val(data.logradouro);
            $('#district').val(data.bairro);
        }
    })
});