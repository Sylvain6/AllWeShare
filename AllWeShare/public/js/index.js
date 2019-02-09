$('.editValues').click(function () {

    var btn = this;
    $(this).parents('tr').find('td.editableColumns').each(function() {
        var html = $(this).html();

        var td_base = $(this).closest('tr').find('td.editableColumns');
        var id = td_base[0].id;

        $("#form_"+id).show();
        td_base.hide();
    });
});


function notif() {
    $.ajax({
        url : 'notif.php',
        success : function(data) {
            if(data) {
                $('#notif').html("<a href='#' class='nav-link'><i class='fas fa-bell fa-lg bell-red'></i></a>");
            }
        }
    });
    setTimeout("notif()", 1000);
}