$('#add-images').click(function () {
    const index = +$('#counter').val();
    const tmpl = $('#etapes_image').data('prototype').replace(/__name__/g, index);
    console.log(tmpl);
    $('#etapes_image').append(tmpl);
    $('#counter').val(index +1);
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#etapes_image div.form-group').length;

    $('#counter').val(count);
}

updateCounter();
handleDeleteButtons();