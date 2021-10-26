$(document).on('click', '#modalButton', function(e) {
            $('#modal_tag').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
});

$(document).on('click', '#modalButtonImport', function(e) {
    $('#import_user').modal('show')
        .find('#modalContentImport')
        .load($(this).attr('value'));
});
