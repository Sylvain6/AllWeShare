/** Ajax Like **/

var idLike = document.getElementById("like").value;
var likeButton = document.getElementById("likeButton");
console.log(idLike);
var xhr = new XMLHttpRequest();
likeButton.addEventListener("click", function(){
    xhr.open('GET', window.location.host + '/'+idLike+'/like/up');
    xhr.onload = function() {
        if (xhr.status === 200 ) {
            alert(xhr.responseText)
        } else {
            alert('Request failed ' + xhr.status)
        }
    };

    xhr.send();
});