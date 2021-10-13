$(function () {
    $('#modalButton').click(function () {
        $('#modal_tag').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});

