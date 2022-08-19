$(document).on('click', '.confirm-submit', function(event){
    event.preventDefault(); //evita o envio do form
    const confirmation = confirm("Tem certeza que deseja excluir este evento?");
    if (confirmation){
        const form = $(this).parent();
        form.trigger('submit');
    }
});