
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
                var content_notif = "";
                $.each( data.notifs, function( i, notif ){
                       // $('#list-notif').append(
                            content_notif +="<li class='list-notif'>" +
                            "<span class='closebtn' onclick='dismiss("+ data.notifs[i][0]+");'>&times;</span>" +
                            data.notifs[i][1] +
                            "</li>"
                       // );


                    }
                );

                $('#list-notif').html( content_notif );

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
}

function editComment( id_comment ) {

    var text = $('#edit_'+id_comment);
    var html = text.html();

    text.hide();
    $('#edit-icon_'+id_comment).hide();
    $('#div_comment_'+id_comment).show();
    $.ajax({
        url : "/comment/"+ id_comment+"/edit" ,
        type: 'GET',
        success : function (data) {

            console.log( data );

            $('#div_comment_'+id_comment).html( data );

            tinymce.init({
                selector: 'textarea#comment_content',
                height: 150,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tiny.cloud/css/codepen.min.css'
                ]
            });
        }
    });

}


function assignDefaultForm() {


    target = $("#signin");
    $.ajax({

        url : "/register" ,
        success : function(data) {

            $('.tab-content').append(data);

        }
    });

    $('.tab-content > form').not(target).hide();
}