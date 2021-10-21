$(document).on('click', '#modalButton', function(e) {
    // $(function () {
    //     $('#modalButton').click(function () {
            $('#modal_tag').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        // });
    // });
});
