$('#add-image').click(function () {

    // je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    // je récupère le proto des entrées
    const tmpl = $('#voyage_images').data('prototype').replace(/__name__/g, index);
    console.log(tmpl);

    //j'injecte ce code dans la div
    $('#voyage_images').append(tmpl);


    $('#widgets-counter').val(index +1);

    //je gère le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#voyage_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();