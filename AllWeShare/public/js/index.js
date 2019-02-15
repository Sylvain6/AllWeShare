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
        url : "/notif" ,
        success : function(data) {
            if(data.counter > 0 ) {
                $('.notif_second_id').html("<i class='fas fa-bell fa-lg'></i><span class='badge-notif'>"+data.counter +"</span></a>");

                $.each( data.notifs, function( i, notif ){
                        $('#list-notif').html(
                            "<li class='list-group-item alert'>" +
                            "<span class='closebtn' onclick='dismiss("+ notif[0]+");'>&times;</span>" +
                             notif[1] +
                            "</li>"
                        );
                    }
                )

            }
            else{
                $('.notif_second_id').html("<i class='fas fa-bell fa-lg'></i></a>");
            }
        }
    });
    setTimeout("notif()", 30000);
}

function dismiss( id ){
    //element.parentElement.style.display='none';

    $.ajax({
        url : "/notif_dismiss" ,
        type: 'POST',
        data: 'id=' + id,
        success : function () {

        }
    });
};