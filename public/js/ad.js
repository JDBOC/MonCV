


function updateCounter() {
    const count = +$('#ad_Images div.form-group').length;

    $('#widgets-counter').val(count);
}
    $('#add-image').click(function() {


        const index = +$('#widgets-counter').val();
        const tmpl = $('#portfolio_images').data('prototype').replace(/__name__/g, index);
        console.log(tmpl);
        $('#ad_Images').append(tmpl);


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
updateCounter();
handleDeleteButtons();
