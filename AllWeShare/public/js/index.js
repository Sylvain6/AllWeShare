$('.editValues').click(function () {

    var btn = this;
    $(this).parents('tr').find('td.editableColumns').each(function() {
        var html = $(this).html();

        var td_base = $(this).closest('tr').find('td.editableColumns');
        var id = td_base[0].id;
        console.log( td_base );
        $("#form_"+id).show();
        td_base.hide();
    });
});
